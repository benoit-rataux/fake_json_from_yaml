<?php

namespace App\Entity;

use App\Repository\NestedTemplateNodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NestedTemplateNodeRepository::class)]
class NestedTemplateNode extends Node {

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Template $nestedTemplate = null;

    public function getNestedTemplate(): ?Template {
        return $this->nestedTemplate;
    }

    public function setNestedTemplate(?Template $template): static {
        $this->nestedTemplate = $template;

        return $this;
    }

}
