<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: RendezVousRepository::class)]

class RendezVous
    {#[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idRv=null;

    #[ORM\Column(length: 255)]
    private ?string $dateRv=null;

    #[ORM\Column(length: 255)]
    private ?string $heureRv=null;

    #[ORM\OneToMany(mappedBy: 'id_rdv', targetEntity: CategorieRdv::class)]
    private Collection $categorieRdvs;

    #[ORM\ManyToOne(inversedBy: 'rendezVouses')]
    #[ORM\JoinColumn(name: 'id_patient', referencedColumnName: 'id_user')]
    private ?Utilisateur $id_patient = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVouses')]
    #[ORM\JoinColumn(name: 'id_medecin', referencedColumnName: 'id_user')]
    private ?Utilisateur $id_medecin = null;

    public function __construct()
    {
        $this->categorieRdvs = new ArrayCollection();
    }


    public function getIdRv(): ?int
    {
        return $this->idRv;
    }

    public function getDateRv(): ?\DateTimeInterface
    {
        return $this->dateRv;
    }

    public function setDateRv(\DateTimeInterface $dateRv): self
    {
        $this->dateRv = $dateRv;

        return $this;
    }

    public function getHeureRv(): ?string
    {
        return $this->heureRv;
    }

    public function setHeureRv(string $heureRv): self
    {
        $this->heureRv = $heureRv;

        return $this;
    }

    /**
     * @return Collection<int, CategorieRdv>
     */
    public function getCategorieRdvs(): Collection
    {
        return $this->categorieRdvs;
    }

    public function addCategorieRdv(CategorieRdv $categorieRdv): self
    {
        if (!$this->categorieRdvs->contains($categorieRdv)) {
            $this->categorieRdvs->add($categorieRdv);
            $categorieRdv->setIdRdv($this);
        }

        return $this;
    }

    public function removeCategorieRdv(CategorieRdv $categorieRdv): self
    {
        if ($this->categorieRdvs->removeElement($categorieRdv)) {
            // set the owning side to null (unless already changed)
            if ($categorieRdv->getIdRdv() === $this) {
                $categorieRdv->setIdRdv(null);
            }
        }

        return $this;
    }

    public function getIdPatient(): ?Utilisateur
    {
        return $this->id_patient;
    }

    public function setIdPatient(?Utilisateur $id_patient): self
    {
        $this->id_patient = $id_patient;

        return $this;
    }

    public function getIdMedecin(): ?Utilisateur
    {
        return $this->id_medecin;
    }

    public function setIdMedecin(?Utilisateur $id_medecin): self
    {
        $this->id_medecin = $id_medecin;

        return $this;
    }






}
