<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discriminator', type: 'string')]
#[ORM\DiscriminatorMap([
    'list'     => 'App\Entity\ListNode',
    'template' => 'App\Entity\NestedTemplateNode',
    'faker'    => 'App\Entity\FakerNode',
])]
abstract class Node {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 20)]
    protected ?string $label = null;

    #[ORM\Column(length: 80, nullable: true)]
    protected ?string $instructions = null;

    #[ORM\ManyToOne(inversedBy: 'nodes')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Template $template = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getLabel(): ?string {
        return $this->label;
    }

    public function setLabel(string $label): static {
        $this->label = $label;

        return $this;
    }

    public function getInstructions(): ?string {
        return $this->instructions;
    }

    public function setInstructions(?string $instructions): static {
        $this->instructions = $instructions;

        return $this;
    }

    public function getNestedTemplate(): ?Template {
        return $this->template;
    }

    public function setNestedTemplate(?Template $template): static {
        $this->template = $template;

        return $this;
    }

}
