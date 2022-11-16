<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieRdvRepository;
#[ORM\Entity(repositoryClass:CategorieRdvRepository::class)]
class  CategorieRdv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCategorieRdv =null;

   #[ORM\Column(length: 50)]
   private ?RendezVous $categorie =null;

   #[ORM\ManyToOne(inversedBy: 'categorieRdvs')]
   #[ORM\JoinColumn(name: 'id_rdv', referencedColumnName: 'id_rv')]
   private ?RendezVous $id_rdv = null;


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

    public function getIdRdv(): ?RendezVous
    {
        return $this->id_rdv;
    }

    public function setIdRdv(?RendezVous $id_rdv): self
    {
        $this->id_rdv = $id_rdv;

        return $this;
    }




}
