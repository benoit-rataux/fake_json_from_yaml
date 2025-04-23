<?php

namespace App\Provider;

use App\Entity\Template;
use App\Service\Configuration;
use Symfony\Component\Yaml\Yaml;

class TemplateProvider {

    public static function find(string $templateName): Template {
        $templateStruct = Yaml::parseFile(Configuration::templatesDirectory()
                                          . "$templateName.yaml",
        );

        return (new Template())->setName($templateName)
                               ->setStructure($templateStruct)
        ;
    }

}