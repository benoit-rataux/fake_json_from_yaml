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

        foreach($this->template->getStructure() as $key => $value) {
            if($key === 'id') {
                $fakeItem[$key] = $this->id($value);
                continue;
            }

            $isList = is_array($value) && array_is_list($value);
            if($isList) {
                $fakeItem[$key] = $this->randomItem($value);
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

            //@TODO: améliorer les dateTime
            if($value === 'datetime') {
                $fakeItem[$key] = $this->randomDateTime();
                continue;
            }

            try {
                $fakeItem[$key] = $this->faker->$value;
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

    private function randomItem(array $list) {
        $countItems      = sizeof($list);
        $randomItemIndex = $this->faker->numberBetween(1, $countItems) - 1;
        return $list[$randomItemIndex];
    }

    private function randomDateTime() {
        $formatedDateTime = $this->faker->dateTime()->format('Y-m-d H:i:s');
        return str_replace(' ', 'T', $formatedDateTime);
    }

    private function id(string|null $value) {

        if($value === null) {
            return $this->autoIncID();
        }

        $isRandom = preg_match('~^rng\s?(?<number>\d+)*$~',
                               $value,
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


}
