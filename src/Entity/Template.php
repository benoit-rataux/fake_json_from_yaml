<?php

namespace App\Entity;

class Template {

    private string $name;
    private array  $structure;

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