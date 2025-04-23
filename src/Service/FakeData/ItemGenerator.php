<?php

namespace App\Service\FakeData;

use App\Entity\Template;
use Exception;
use Faker\Generator;

class ItemGenerator {

    private int $quantityToCreate  = 1;
    private int $countItemsCreated = 0;

    public function __construct(
        private readonly Generator $faker,
        private readonly Template  $template,
    ) {}

    public function createOne(): array {

        $fakeItem = [];
        $this->countItemsCreated++;

        foreach($this->template->getStructure() as $key => $value) {
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
                    $maxID = $matches['number'] ?? $this->quantityToCreate;
                    try {
                        $fakeItem[$key] = $this->faker->unique()->numberBetween(1, $maxID);

                    }
                    catch(Exception $exception) {
                        $fakeItem[$key] = $this->faker->numberBetween(1, $maxID);
                    }
                    continue;
                }
            }

            if(is_array($value) && array_is_list($value)) {
                $countItems      = array_count_values($value);
                $randomItemIndex = $this->faker->numberBetween(0, $countItems);
                $fakeItem[$key]  = $value[$randomItemIndex];
                continue;
            }

            if(is_array($value)) {
                $fakeItem[$key] = $this->createSubItem($key, $value);
                continue;
            }

            if($value == 'template') {
                $fakeItem[$key] = $this->createSubItem($key);
                continue;
            }

            try {
                $fakeItem[$key] = $this->faker->$value;
                //@TODO: améliorer les dateTime
                //@TODO: option d'ajouter le mot clé 'unique' en préfixe dans $value
            }
            catch(Exception $e) {
                $fakeItem[$key] = $value;
            }
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
        int $quantity = 1,
    ): array {
        if($quantity === 1) return $this->createOne();
        else                return $this->createList($quantity);
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

}
