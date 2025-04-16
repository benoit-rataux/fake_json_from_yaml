<?php

namespace App\Service\FakeData;

use Exception;
use Faker\Generator;

class ArrayGenerator {
    public function __construct(
        private readonly Generator $faker,
    ) { }

    public function createOneFromTemplate(
        array     $templateArray,
    ): array {

        $filledArray = [];

        foreach ($templateArray as $key => $value) {
            if($key === 'id' && $value !== 'uuid'){
                $filledArray[$key] = $this->faker->numberBetween(1, 99);
                continue;
            }
            if (is_null($value)) {
                $filledArray[$key] = $value;
                continue;
            }
            if (is_array($value)) {
                $filledArray[$key] = $this->createOneFromTemplate($value);
                continue;
            }
            try {
            $filledArray[$key] = $this->faker->$value;
            }catch (Exception $e) {
                $filledArray[$key] = $value;
            }
        }

        return $filledArray;
    }

    public function createListFromTemplate(
        array $template,
        int $quantity,
    ): array {
        $list = [];

        for($i = 0; $i < $quantity; ++$i){
            $list[] = $this->createOneFromTemplate($template);
        }

        return $list;
    }

    public function createFromTemplate(
        array $template,
        int $quantity = 1,
    ): array {
        if($quantity === 1) return $this->createOneFromTemplate($template);
        return $this->createListFromTemplate($template, $quantity);
    }
}
