<?php

namespace App\ValueResolver;

use App\Entity\FakerNode;
use App\Entity\ListNode;
use App\Entity\NestedTemplateNode;
use App\Entity\Node;
use App\Entity\Template;
use App\Model\GenerationRequest;
use App\ValueResolver\Attribute\MapJsonGenerationRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Yaml;

final class GenerationRequestResolver implements ValueResolverInterface {

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface  $validator,
    ) {}

    /**
     * @inheritDoc
     */
    public function resolve(Request          $request,
                            ArgumentMetadata $argument,
    ): iterable {
        $attribute = $argument->getAttributes(
            MapJsonGenerationRequest::class,
            ArgumentMetadata::IS_INSTANCEOF,
        )[0] ?? null;

        if(!($attribute instanceof MapJsonGenerationRequest))
            return [];


        $payload = Yaml::parse($request->getContent());

        $generationRequest = $this->toGenerationRequest($payload);


//        $generationRequest = $this->serializer->deserialize(
//            $request->getContent(),
//            GenerationRequest::class,
//            $request->getContentTypeFormat(),
//            ['groups' => $attribute->groups],
//        );


//        dd($generationRequest);
        return [$generationRequest];
    }

    private function toGenerationRequest(array $data): GenerationRequest {
        return (new GenerationRequest())
            ->setQuantity(1)
            ->setTemplate($this->toTemplate($data));
    }

    private function toTemplate(array $data): Template {
        $template = new Template();

        foreach($data as $nodeLabel => $nodeData) {
            $template->addNode(
                $this->toNode(
                    $nodeLabel,
                    $nodeData,
                ),
            );
        }

        return $template;
    }

    private function toListNode(string $label, array $data): ListNode {
        return (new ListNode())->setLabel($label)
                               ->setList($data);
    }

    private function toNestedTemplateNode(string $label, array $data): NestedTemplateNode {
        return (new NestedTemplateNode())->setLabel($label);
    }

    private function toFakerNode(string $label, mixed $data): FakerNode {
        return (new FakerNode())->setLabel($label)
                                ->setInstructions($data);
    }

    private function toNode(
        string $label,
        mixed  $data,
    ): Node {
        if(is_array($data) && array_is_list($data))
            return $this->toListNode($label, $data);

        if(is_array($data))
            return $this->toNestedTemplateNode($label, $data);

        return $this->toFakerNode($label, $data);
    }

}