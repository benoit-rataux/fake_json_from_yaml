<?php

namespace App\Entity;

use App\Repository\ItemTemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemTemplateRepository::class)]
class ItemTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, ItemTemplateEntry>
     */
    #[ORM\OneToMany(targetEntity: ItemTemplateEntry::class, mappedBy: 'template', orphanRemoval: true)]
    private Collection $entries;

    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ItemTemplateEntry>
     */
    public function getEntries(): Collection
    {
        return $this->entries;
    }

    public function addEntry(ItemTemplateEntry $entry): static
    {
        if (!$this->entries->contains($entry)) {
            $this->entries->add($entry);
            $entry->setTemplate($this);
        }

        return $this;
    }

    public function removeEntry(ItemTemplateEntry $entry): static
    {
        if ($this->entries->removeElement($entry)) {
            // set the owning side to null (unless already changed)
            if ($entry->getTemplate() === $this) {
                $entry->setTemplate(null);
            }
        }

        return $this;
    }
}
