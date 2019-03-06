<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NavetteRepository")
 */
class Navette
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Trajet", inversedBy="navette", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $trajet;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classe", inversedBy="navettes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classe;

     /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tracabilite", mappedBy="navette")
     */
    private $tracabilites;

    public function __construct()
    {
        $this->tracabilites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrajet(): ?Trajet
    {
        return $this->trajet;
    }

    public function setTrajet(Trajet $trajet): self
    {
        $this->trajet = $trajet;

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

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Tracabilite[]
     */
    public function getTracabilites(): Collection
    {
        return $this->tracabilites;
    }

    public function addTracabilite(Tracabilite $tracabilite): self
    {
        if (!$this->tracabilites->contains($tracabilite)) {
            $this->tracabilites[] = $tracabilite;
            $tracabilite->setNavette($this);
        }

        return $this;
    }

    public function removeTracabilite(Tracabilite $tracabilite): self
    {
        if ($this->tracabilites->contains($tracabilite)) {
            $this->tracabilites->removeElement($tracabilite);
            // set the owning side to null (unless already changed)
            if ($tracabilite->getNavette() === $this) {
                $tracabilite->setNavette(null);
            }
        }

        return $this;
    }
}
