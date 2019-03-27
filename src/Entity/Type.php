<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 */
class Type
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Abonnement", mappedBy="type")
     */
    private $abonnements;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $section;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vignette", mappedBy="type")
     */
    private $vignettes;

    public function __construct()
    {
        $this->abonnements = new ArrayCollection();
        $this->vignettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection|Abonnement[]
     */
    public function getAbonnements(): Collection
    {
        return $this->abonnements;
    }

    public function addAbonnement(Abonnement $abonnement): self
    {
        if (!$this->abonnements->contains($abonnement)) {
            $this->abonnements[] = $abonnement;
            $abonnement->setType($this);
        }

        return $this;
    }

    public function removeAbonnement(Abonnement $abonnement): self
    {
        if ($this->abonnements->contains($abonnement)) {
            $this->abonnements->removeElement($abonnement);
            // set the owning side to null (unless already changed)
            if ($abonnement->getType() === $this) {
                $abonnement->setType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->libelle.' '.$this->section;
    }

    public function getSection(): ?string
    {
        return $this->section;
    }

    public function setSection(string $section): self
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return Collection|Vignette[]
     */
    public function getVignettes(): Collection
    {
        return $this->vignettes;
    }

    public function addVignette(Vignette $vignette): self
    {
        if (!$this->vignettes->contains($vignette)) {
            $this->vignettes[] = $vignette;
            $vignette->setType($this);
        }

        return $this;
    }

    public function removeVignette(Vignette $vignette): self
    {
        if ($this->vignettes->contains($vignette)) {
            $this->vignettes->removeElement($vignette);
            // set the owning side to null (unless already changed)
            if ($vignette->getType() === $this) {
                $vignette->setType(null);
            }
        }

        return $this;
    }


}
