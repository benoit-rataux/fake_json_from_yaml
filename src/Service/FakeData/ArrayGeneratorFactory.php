<?php

namespace App\Service\FakeData;

use Faker\Factory;
class ArrayGeneratorFactory {

    public static function create(): ArrayGenerator {
        return new ArrayGenerator(Factory::create());
    }
}
