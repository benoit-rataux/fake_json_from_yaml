<?php

namespace App\Entity;

use App\Repository\InstructionsNodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstructionsNodeRepository::class)]
class InstructionsNode extends Node {

    #[ORM\Column(length: 80, nullable: true)]
    protected ?string $instructions = null;

    public function getInstructions(): ?string {
        return $this->instructions;
    }

    public function setInstructions(?string $instructions): static {
        $this->instructions = $instructions;

        return $this;
    }

}
