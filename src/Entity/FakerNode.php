<?php

namespace App\Entity;

use App\Repository\FakerNodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FakerNodeRepository::class)]
class FakerNode extends Node {}
