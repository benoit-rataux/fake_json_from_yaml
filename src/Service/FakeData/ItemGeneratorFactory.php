<?php

namespace App\Service\FakeData;

use Faker\Factory;
use Symfony\Component\Yaml\Yaml;

class ItemGeneratorFactory {

    private static string $CONF_FILE = __DIR__ . '/../../../conf/faker.yaml';
    private static array  $conf;
    private static array  $generators;

    public static function create(string $itemType): ItemGenerator {

        $conf                        ??= Yaml::parseFile(self::$CONF_FILE);
        self::$generators[$itemType] ??= new ItemGenerator(Factory::create($conf['locale']));

        return self::$generators[$itemType];
    }

}
