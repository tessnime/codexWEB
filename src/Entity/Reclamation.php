<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="id_categorie", columns={"id_categorie"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_reclamation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReclamation;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=1000, nullable=false)
     */
    private $message;

    /**
     * @var string|null
     *
     * @ORM\Column(name="date_reclamation", type="string", length=255, nullable=true)
     */
    private $dateReclamation;

    /**
     * @var string
     *
     * @ORM\Column(name="objet_reclamation", type="string", length=50, nullable=false)
     */
    private $objetReclamation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="etat_reclamation", type="string", length=255, nullable=true, options={"default"="non traité"})
     */
    private $etatReclamation = 'non traité';

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @var \Catégorie
     *
     * @ORM\ManyToOne(targetEntity="Catégorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie", referencedColumnName="id_categorie")
     * })
     */
    private $idCategorie;

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
        return $this->idUser;
    }

    public function setIdUser(?Utilisateur $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdCategorie(): ?Catégorie
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(?Catégorie $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }


}
