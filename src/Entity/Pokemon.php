<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'json')]
    private array $type = [];

    #[ORM\Column(type: 'json')]
    private array $abilities = [];

    #[ORM\Column(type: 'json')]
    private array $moves = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sprite = null;

    // Getters and setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getType(): array
    {
        return $this->type;
    }

    public function setType(array $type): void
    {
        $this->type = $type;
    }

    public function getAbilities(): array
    {
        return $this->abilities;
    }

    public function setAbilities(array $abilities): void
    {
        $this->abilities = $abilities;
    }

    public function getMoves(): array
    {
        return $this->moves;
    }

    public function setMoves(array $moves): void
    {
        $this->moves = $moves;
    }

    public function getSprite(): ?string
    {
        return $this->sprite;
    }

    public function setSprite(?string $sprite): void
    {
        $this->sprite = $sprite;
    }
}
