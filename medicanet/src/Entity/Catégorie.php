<?php

namespace App\Entity;

use App\Repository\CatégorieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass:CatégorieRepository::class)]
class Catégorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCategorie = null;

    #[ORM\Column(length: 255)]
    private ?String $typeReclamation = null;

    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }

    public function getTypeReclamation(): ?string
    {
        return $this->typeReclamation;
    }

    public function setTypeReclamation(string $typeReclamation): self
    {
        $this->typeReclamation = $typeReclamation;

        return $this;
    }


}
