<?php

namespace App\Entity;

use App\Service\Configuration;
use Symfony\Component\Yaml\Yaml;

class Template {

    private string $name;
    private array  $structure;

    /**
     * @param string $name
     */
    public function __construct(
        string $name,
        array  $structure = null,
    ) {
        $this->name      = $name;
        $this->structure = $structure ?? Yaml::parseFile(
        //@TODO: TemplateProvider
            __DIR__ . '/../../' . Configuration::templatesDirectory() . "/$name.yaml",
        );
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): Template {
        $this->name = $name;
        return $this;
    }

    public function getStructure(): array {
        return $this->structure;
    }

    public function setStructure(array $structure): Template {
        $this->structure = $structure;
        return $this;
    }

}