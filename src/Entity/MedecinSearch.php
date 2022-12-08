<?php
namespace App\Entity;


class MedecinSearch{
    /**
     * @var string
     *
     */
    #[Assert\NotBlank]
    private $nomMed;

    /**
     * @var string
     *
     */
    #[Assert\NotBlank]
    private $specialiteMed;

    public function getNomMed(): ?string
    {
        return $this->nomMed;
    }

    public function setNomMed(string $nomMed): self
    {
        $this->nomMed = $nomMed;

        return $this;
    }

    public function getSpecialiteMed(): ?string
    {
        return $this->specialiteMed;
    }

    public function setSpecialiteMed(string $specialiteMed): self
    {
        $this->specialiteMed = $specialiteMed;

        return $this;
    }
}