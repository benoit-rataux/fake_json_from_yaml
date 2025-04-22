<?php

namespace App\Service;

use Symfony\Component\Yaml\Yaml;

class Configuration {

    private static string $CONF_FILE = __DIR__ . '/../../conf/json_template.yaml';
    private static array  $conf;

    private static function conf(): array {
        self::$conf ??= Yaml::parseFile(self::$CONF_FILE);
        return self::$conf;
    }

    public static function templatesDirectory() { return self::conf()['templates_directory']; }

    public static function templateName() { return self::conf()['template']['name']; }

    public static function quantityToGenerate() { return self::conf()['template']['quantity']; }

}