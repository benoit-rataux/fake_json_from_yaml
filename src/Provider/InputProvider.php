<?php

namespace App\Provider;

use App\Service\Utils;
use Symfony\Component\Yaml\Yaml;

class InputProvider {

    private static string $PATH       = '';
    private static string $INPUT_FILE = 'input.yaml';
    private static array  $conf;

    private static function conf(): array {
        self::$conf ??= Yaml::parseFile(Utils::$APP_ROOT
                                        . self::$PATH
                                        . self::$INPUT_FILE,
        );
        return self::$conf;
    }

    public static function templatesDirectory() {
        return self::conf()['templates_directory'] . '/';
    }

    public static function templateName() {
        return self::conf()['template']['name'];
    }

    public static function quantityToGenerate() {
        return self::conf()['template']['quantity'];
    }

}