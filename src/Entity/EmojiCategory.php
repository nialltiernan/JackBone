<?php

namespace App\Entity;

use App\Repository\EmojiCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: EmojiCategoryRepository::class)]
class EmojiCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 50)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Emoji::class)]
    private Collection $emojis;

    #[Pure]
    public function __construct()
    {
        $this->emojis = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getEmojis(): Collection
    {
        return $this->emojis;
    }
}
