<?php

namespace App\Repository;

use App\Service\Utils;

class ItemRepository {

    public static string $OUTPUT_DIR = __DIR__ . '/../../output/';

    public function save(array $item): void {
        $jsonItem = json_encode($item);
        $jsonItem = stripslashes($jsonItem);
        file_put_contents(
            self::$OUTPUT_DIR . 'default.json',
            $jsonItem,
        );
    }

}