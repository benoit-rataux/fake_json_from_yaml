<?php

namespace App\Tests\unit;

use App\ValueResolver\GenerationRequestResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

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

        $yaml = "test: 1\n     huhu:2\n";

        $result = $this->resolver->resolve(Request::create(
            '/api/generate',
            'POST',
            [
                'quantity' => 2,
                'locale'   => 'fr_FR',
            ],
        ),
        );

        self::assertIsArray($result);
    }

}