<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * CategorieRdv
 *
 * @ORM\Table(name="categorie_rdv", indexes={@ORM\Index(name="id_RDV_", columns={"id_rdv"})})
 * @ORM\Entity
 */
class CategorieRdv
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_categorie_rdv", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCategorieRdv;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable=false)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 10,
        max: 50,
        minMessage: 'Description must be at least {{ limit }} characters long',
        maxMessage: 'Description cannot be longer than {{ limit }} characters',
    )]
    private $description;

    /**
     * @var \RendezVous
     *
     * @ORM\ManyToOne(targetEntity="RendezVous")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_rdv", referencedColumnName="id_RV")
     * })
     */
    private $idRdv;

    public function getIdCategorieRdv(): ?int
    {
        return $this->idCategorieRdv;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdRdv(): ?RendezVous
    {
        return $this->idRdv;
    }

    public function setIdRdv(?RendezVous $idRdv): self
    {
        $this->idRdv = $idRdv;

        return $this;
    }


}
