<?php

namespace App\Service\FakeData;

use Exception;
use Faker\Generator;

class ItemGenerator {

    private $quantityToCreate  = 1;
    private $countItemsCreated = 0;

    public function __construct(
        private readonly Generator $faker,
    ) {}

    public function createOne(
        array $template,
    ): array {

        $fakeItem = [];
        $this->countItemsCreated++;

        foreach($template as $key => $value) {
            if($key === 'id') {

                if($value === null) {
                    //id: null        --> incrément automatique, commençant par 1
                    $fakeItem[$key] = $this->countItemsCreated;
                    continue;
                }

                $isRandom = preg_match('~^rng\s?(?<number>\d+)*$~',
                                       $value,
                                       $matches,
                                       PREG_UNMATCHED_AS_NULL,
                );

                if($isRandom) {
                    //id: rng         --> entier unique aléatoire, entre 1 et [nombre d'item]
                    //id: rng [value] --> entier unique aléatoire, entre 1 et [value]
                    $maxID          = $matches['number'] ?? $this->quantityToCreate;
                    $fakeItem[$key] = $this->faker->unique()->numberBetween(1, $maxID);
                    continue;
                }
            }

            if(is_array($value)) {
//                $fakeItem[$key] = $this->createOne($value);
                $subItemGenerator = ItemGeneratorFactory::create($key);
                $fakeItem[$key]   = $subItemGenerator->createOne($value);
                continue;
            }

            try {
                $fakeItem[$key] = $this->faker->$value;

            }
            catch(Exception $e) {
                $fakeItem[$key] = $value;
            }
        }

        return $fakeItem;
    }

    public function createList(
        array $template,
        int   $quantity,
    ): array {
        $list                   = [];
        $this->quantityToCreate = $quantity;

        for($i = 0; $i < $quantity; ++$i) {
            $list[] = $this->createOne($template);
        }

        return $list;
    }

    public function create(
        array $template,
        int   $quantity = 1,
    ): array {
        if($quantity === 1) return $this->createOne($template);
        else                return $this->createList($template, $quantity);
    }

}
