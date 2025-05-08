<?php

namespace App\Tests\unit;

use App\ValueResolver\GenerationRequestResolver;
use PHPUnit\Framework\TestCase;

class GenerationRequestResolverTest extends TestCase {

    public function __construct(
        private readonly GenerationRequestResolver $resolver,
    ) {
        parent::__construct();
    }

    protected function setUp(): void {
        parent::setUp();
    }

    public function toYaml_fromString_mustReturnAnArray(): void {

        $yaml = "test: 1\n     template:";

        $result = $this->resolver->toYaml($yaml);

        self::assertIsArray($result);
    }

}