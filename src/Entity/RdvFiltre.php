<?php

namespace App\Entity;

use App\Repository\RdvFiltreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RdvFiltreRepository::class)]
class RdvFiltre
{
    /**
     * @var string
     *
     */
    #[Assert\NotBlank]
    private $etatRdv;

    public function getEtatRdv(): ?string
    {
        return $this->etatRdv;
    }

    public function setEtatRdv(string $etatRdv): self
    {
        $this->etatRdv = $etatRdv;

        return $this;
    }
}
