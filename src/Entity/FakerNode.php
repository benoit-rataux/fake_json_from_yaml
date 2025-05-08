<?php

namespace App\Entity;

use App\Repository\FakerNodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FakerNodeRepository::class)]
class FakerNode extends Node {

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
