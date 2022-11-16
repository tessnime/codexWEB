<?php

namespace App\Entity;

use ContainerEEQsc5v\getDebug_ArgumentResolver_DatetimeService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idArticle =null;

    #[ORM\Column(length: 50)]
    private ?string $titre =null;

    #[ORM\Column(length: 50)]
    private ?string $auteur =null;

    #[ORM\Column(length: 150)]
    private ?string $description = null;

    #[ORM\Column(length: 150)]
    private ?string $dateArticle = null;

    #[ORM\Column(length: 150)]
    private ?string $demandeSupp = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(name: 'id_user', referencedColumnName: 'id_user')]
    private ?Utilisateur $id_user = null;

    #[ORM\OneToMany(mappedBy: 'id_article', targetEntity: Commentaire::class)]
    private Collection $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }








    public function getIdArticle(): ?int
    {
        return $this->idArticle;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

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

    public function getDateArticle(): ?\DateTimeInterface
    {
        return $this->dateArticle;
    }

    public function setDateArticle(\DateTimeInterface $dateArticle): self
    {
        $this->dateArticle = $dateArticle;

        return $this;
    }

    public function getDemandeSupp(): ?string
    {
        return $this->demandeSupp;
    }

    public function setDemandeSupp(string $demandeSupp): self
    {
        $this->demandeSupp = $demandeSupp;

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

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setIdArticle($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getIdArticle() === $this) {
                $commentaire->setIdArticle(null);
            }
        }

        return $this;
    }





}
