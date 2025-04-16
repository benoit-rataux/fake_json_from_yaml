<?php

namespace App\Service\FakeData;

use Faker\Factory;
use Symfony\Component\Yaml\Yaml;

class ArrayGeneratorFactory {
    private static string $CONF_FILE = __DIR__.'/../../../conf/faker.yaml';

    public static function create(): ArrayGenerator {
        $conf = Yaml::parseFile(self::$CONF_FILE);
        return new ArrayGenerator(Factory::create($conf['locale']));
    }
}
