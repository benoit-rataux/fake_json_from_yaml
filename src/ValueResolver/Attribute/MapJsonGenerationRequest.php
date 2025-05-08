<?php

namespace App\ValueResolver\Attribute;


use App\ValueResolver\GenerationRequestResolver;
use Attribute;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Validator\Constraints\GroupSequence;

#[Attribute(Attribute::TARGET_PARAMETER)]
class MapJsonGenerationRequest extends ValueResolver {

    public function __construct(
        public readonly array                           $groups = [],
        public readonly string|GroupSequence|array|null $validationGroups = null,
    ) {
        parent::__construct(GenerationRequestResolver::class);
    }

}