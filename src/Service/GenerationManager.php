<?php

namespace App\Service;

use App\Entity\InstructionsNode;
use App\Entity\ListNode;
use App\Entity\NestedTemplateNode;
use App\Entity\Node;
use App\Entity\Template;
use App\Model\GenerationRequest;
use Exception;

class GenerationManager {

    private $faker;

    public function __construct() {
        $this->faker = \Faker\Factory::create('fr_FR');
    }


    /**
     * @throws \Exception
     */
    public function generate(
        GenerationRequest $generationRequest,
    ): array {
        $template = $generationRequest->getTemplate();
        $quantity = $generationRequest->getQuantity();

        if($quantity <= 1)
            return $this->generateOneItem($template);

        return $this->generateListOfItems($template, $quantity);
    }

    /**
     * @throws Exception
     */
    private function generateListOfItems(Template $template, int $quantity): array {
        $listOfItems = [];

        for($i = 0; $i < $quantity; ++$i) {
            $listOfItems[] = $this->generateOneItem($template);
        }

        return $listOfItems;
    }

    /**
     * @throws \Exception
     */
    private function generateOneItem(Template $template): array {
        $nodes = $template->getNodes();
        $data  = [];

        foreach($nodes as $node) {
            $data = $this->constructResponse($node, $data);
        }
        return $data;
    }

    /**
     * @throws \Exception
     */
    private function constructResponse(Node $node, array $response): array {
        $response[$node->getLabel()] = $this->evaluate($node);
        return $response;
    }

    /**
     * @throws \Exception
     */
    private function evaluate(Node $node): mixed {
        if($node instanceof ListNode) return $this->evaluateList($node);
        if($node instanceof NestedTemplateNode) return $this->evaluateNestedTemplate($node);
        if($node instanceof InstructionsNode) return $this->evaluateInstructions($node);
        throw new \Exception('Generation don\'t support this type of Node : ' . $node::class);
    }

    private function evaluateList(ListNode $node): mixed {
        $list     = $node->getList();
        $rngIndex = $this->faker->numberBetween(
            0,
            sizeof($list) - 1,
        );
        return $list[$rngIndex];
    }

    /**
     * @throws \Exception
     */
    private function evaluateNestedTemplate(NestedTemplateNode $node): array {
        return $this->generateOneItem($node->getNestedTemplate());
    }

    private function evaluateInstructions(InstructionsNode $node): mixed {

        try {
            $instructions = explode('->', $node->getInstructions());
            $execute      = $this->faker;

            foreach($instructions as $instruction) {
                $matches = [];

                preg_match(
                    '/([a-zA-Z0-9]+)(\((.+)\))*/',
                    $instruction,
                    $matches,
                );

                $fn     = $matches[1];
                $params = explode(',', $matches[3] ?? '');

                $execute = $execute->{$fn}(...$params);
            }

            return $execute;

        } catch(Exception $exception) {

//            dd($exception);
            return $node->getInstructions();
        }
    }


}