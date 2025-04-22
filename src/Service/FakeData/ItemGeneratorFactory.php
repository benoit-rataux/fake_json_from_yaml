<?php

namespace App\Service\FakeData;

use App\Entity\Template;
use Faker\Factory;
use Symfony\Component\Yaml\Yaml;

class ItemGeneratorFactory {

    private static string $CONF_FAKER_FILE = __DIR__ . '/../../../conf/faker.yaml';
    private static array  $confFaker;
    private static array  $generators;

    public static function create(
        string $templateName,
        array  $templateStruct = null,
    ): ItemGenerator {

        self::$confFaker                 ??= Yaml::parseFile(self::$CONF_FAKER_FILE);
        self::$generators[$templateName] ??= new ItemGenerator(
            Factory::create(self::$confFaker['locale']),
            new Template($templateName, $templateStruct),
        );

        return self::$generators[$templateName];
    }

}
