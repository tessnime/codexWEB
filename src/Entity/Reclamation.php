<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;


use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idReclamation = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 10,
        max: 50,
        minMessage: 'Your message must be at least {{ limit }} characters long',
        maxMessage: 'Your message cannot be longer than {{ limit }} characters',
    )]
    private ?String $message = null;

    #[ORM\Column(length: 255)]
    private ?String $dateReclamation = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 10,
        max: 30,
        minMessage: 'Your message must be at least {{ limit }} characters long',
        maxMessage: 'Your message cannot be longer than {{ limit }} characters',
    )]
    private ?String $objetReclamation = null;

    #[ORM\Column(length: 255)]
    private ?String $etatReclamation = 'non traité';

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user')]
    private ?Utilisateur $id_user = null;

    #[ORM\ManyToOne(inversedBy: 'reclamations')]
    #[ORM\JoinColumn(name: 'id_categorie', referencedColumnName: 'id_categorie')]
    private ?Categorie $id_categorie = null;



    public function getIdReclamation(): ?int
    {
        return $this->idReclamation;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDateReclamation(): ?string
    {
        return $this->dateReclamation;
    }

    public function setDateReclamation(?string $dateReclamation): self
    {
        $this->dateReclamation = $dateReclamation;

        return $this;
    }

    public function getObjetReclamation(): ?string
    {
        return $this->objetReclamation;
    }

    public function setObjetReclamation(string $objetReclamation): self
    {
        $this->objetReclamation = $objetReclamation;

        return $this;
    }

    public function getEtatReclamation(): ?string
    {
        return $this->etatReclamation;
    }

    public function setEtatReclamation(?string $etatReclamation): self
    {
        $this->etatReclamation = $etatReclamation;

        return $this;
    }

    public function getIdUser(): ?Utilisateur
    {
        return $this->id_user;
    }

    public function setIdUser(?Utilisateur $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdCategorie(): ?Catégorie
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(?Catégorie $id_categorie): self
    {
        $this->id_categorie = $id_categorie;

        return $this;
    }

   

   
}