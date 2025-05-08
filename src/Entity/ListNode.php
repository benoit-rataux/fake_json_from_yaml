<?php

namespace App\Entity;

use App\Repository\ListNodeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListNodeRepository::class)]
class ListNode extends Node {

    #[ORM\Column(type: Types::JSON)]
    private array $list = [];

    public function getList(): array {
        return $this->list;
    }

    public function setList(array $list): static {
        $this->list = $list;

        return $this;
    }

}
