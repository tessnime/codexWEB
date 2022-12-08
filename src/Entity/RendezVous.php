<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RendezVous
 *
 * @ORM\Table(name="rendez_vous", indexes={@ORM\Index(name="id_medecin", columns={"id_medecin"}), @ORM\Index(name="id_patient", columns={"id_patient"})})
 * @ORM\Entity
 */
class RendezVous
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_RV", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRv;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_RV", type="date", nullable=false)
     */
    #[Assert\NotBlank]
    private $dateRv;

    /**
     * @var string
     *
     * @ORM\Column(name="heure_RV", type="string", length=10, nullable=false)
     */
    #[Assert\NotBlank]
    private $heureRv;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_patient", referencedColumnName="id_user")
     * })
     */
    private $idPatient;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_medecin", referencedColumnName="id_user")
     * })
     */
    private $idMedecin;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIdPatient(): ?Utilisateur
    {
        return $this->idPatient;
    }

    public function setIdPatient(?Utilisateur $idPatient): self
    {
        $this->idPatient = $idPatient;

        return $this;
    }

    public function getIdMedecin(): ?Utilisateur
    {
        return $this->idMedecin;
    }

    public function setIdMedecin(?Utilisateur $idMedecin): self
    {
        $this->idMedecin = $idMedecin;

        return $this;
    }

    

}
