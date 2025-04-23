<?php

namespace App\Provider;

use App\Entity\Template;
use App\Service\Configuration;
use App\Service\Utils;
use Symfony\Component\Yaml\Yaml;

class TemplateProvider {

    public static string $TEMPLATES_DIR = 'json_templates/';

    public static function find(string $templateName): Template {
        $templateStruct = Yaml::parseFile(Utils::$APP_ROOT
                                          . self::$TEMPLATES_DIR
                                          . Configuration::templatesDirectory()
                                          . "$templateName.yaml",
        );

        return (new Template())->setName($templateName)
                               ->setStructure($templateStruct);
    }

}