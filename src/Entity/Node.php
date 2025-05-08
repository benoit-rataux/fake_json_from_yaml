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

}
