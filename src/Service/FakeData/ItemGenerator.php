<?php

namespace App\Service\FakeData;

use App\Entity\Template;
use Exception;
use Faker\Generator;

class ItemGenerator {

    private int $quantityToCreate  = 1;
    private int $countItemsCreated = 0;
    private int $autoIncID         = 1;

    public function __construct(
        private readonly Generator $faker,
        private readonly Template  $template,
    ) {}

    public function createOne(): array {

        $fakeItem = [];
        $this->countItemsCreated++;

        foreach($this->template->getStructure() as $key => $instructions) {
            $fakeItem[$key] = $this->readInstructions($key, $instructions);
        }

        return $fakeItem;
    }

    public function createList(
        int $quantity,
    ): array {
        $list                   = [];
        $this->quantityToCreate = $quantity;

        for($i = 0; $i < $quantity; ++$i) {
            $list[] = $this->createOne();
        }

        return $list;
    }

    public function create(
        int $quantity = null,
    ): array {
        if($quantity === null) return $this->createOne();
        else                   return $this->createList($quantity);
    }

    private function createSubItem(
        string $templateName,
        array  $templateStruct = null,
    ): array {
        $subItemGenerator = ItemGeneratorFactory::create($templateName,
                                                         $templateStruct,
        );
        return $subItemGenerator->createOne();
    }

    private function createSubListOfItems(
        string $templateName,
        int    $quantity,
    ): array {
        $subItemGenerator = ItemGeneratorFactory::create($templateName);
        return $subItemGenerator->create($quantity);
    }

    private function randomItem(array $list) {
        $countItems      = sizeof($list);
        $randomItemIndex = $this->faker->numberBetween(1, $countItems) - 1;
        return $list[$randomItemIndex];
    }


//    private function randomDateTime() {
//        $formatedDateTime = $this->faker->dateTime()->format('Y-m-d H:i:s');
//        return str_replace(' ', 'T', $formatedDateTime);
//    }
//
    private function id(string|null $instruction): int|string {

        if($instruction === null) return $this->autoIncID();
        if($instruction === 'uuid') return $this->faker->uuid();


        $isRandom = preg_match('~^rng\s?(?<number>\d+)*$~',
                               $instruction,
                               $matches,
                               PREG_UNMATCHED_AS_NULL,
        );

        if($isRandom) {
            //id: rng         --> entier unique aléatoire, entre 1 et [nombre d'item]
            //id: rng [maxID] --> entier unique aléatoire, entre 1 et [maxID]
            $maxID = $matches['number'] ?? $this->quantityToCreate;
            return $this->randomID($maxID);
        }

        return $this->autoIncID();
    }

    private function autoIncID() {
        return $this->autoIncID++;
    }

    private function randomID(int $maxID) {
        try {
            return $this->faker->unique()->numberBetween(1, $maxID);

        }
        catch(Exception $exception) {
            return $this->faker->numberBetween(1, $maxID);
        }
    }

    private function callFakerMethods(array $instructions) {
        $call = $this->faker;

        foreach($instructions as $instruction) {

            $call = $call->$instruction;
        }

        return $call;
    }

    private function isList(mixed $instructions): bool {
        return is_array($instructions) && array_is_list($instructions);
    }

    private function isNestedTemplate(mixed $instructions): bool {
        return is_array($instructions);
    }

    private function readInstructions(string $key,
                                      mixed  $instructions,
    ) {

        if($key === 'id') return $this->id($instructions);
        if(!$instructions) return '';
        if($this->isList($instructions)) return $this->randomItem($instructions);
        if($this->isNestedTemplate($instructions)) return $this->createSubItem($key, $instructions);

        $instructionsWords = explode(' ', $instructions);

        if($instructionsWords[0] == 'template') {
            if(sizeof($instructionsWords) == 1) return $this->createSubItem($key);
            if(sizeof($instructionsWords) == 2) return $this->createSubListOfItems($key, $instructionsWords[1]);
            if(sizeof($instructionsWords) == 3) {
                if($instructionsWords[1] === 'rng') {
                    $quantity = $this->faker->numberBetween(0, $instructionsWords[2]);
                    return $this->createSubListOfItems($key, $quantity);
                }
            }
            if(sizeof($instructionsWords) == 4) {
                if($instructionsWords[1] === 'rng') {
                    $quantity = $this->faker->numberBetween($instructionsWords[2], $instructionsWords[3]);
                    return $this->createSubListOfItems($key, $quantity);
                }
            }
        }

//            if($instructions === 'datetime') {
//                $fakeItem[$key] = $this->randomDateTime();
//                continue;
//            }


        try {
            return $this->callFakerMethods($instructionsWords);
        }
        catch(Exception $e) {
            return $instructions;
        }
    }


}
