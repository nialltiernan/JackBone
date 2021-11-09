<?php

namespace App\Entity;

use App\Repository\EmojiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmojiRepository::class)]
class Emoji
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 50)]
    private string $name;

    #[ORM\Column(type: 'string', length: 10)]
    private string $html;

    #[ORM\ManyToOne(targetEntity: EmojiCategory::class, inversedBy: 'emojis')]
    private $category;

    public function getId(): ?int
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

    public function getHtml(): string
    {
        return $this->html;
    }

    public function setHtml(string $html): self
    {
        $this->html = $html;
        return $this;
    }

    public function getCategory(): ?EmojiCategory
    {
        return $this->category;
    }

    public function setCategory(?EmojiCategory $category): self
    {
        $this->category = $category;
        return $this;
    }
}
