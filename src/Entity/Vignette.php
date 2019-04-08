<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VignetteRepository")
 */
class Vignette
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Guichet", inversedBy="vignettes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $guichet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="vignettes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroDernierBillet;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandeVignette", mappedBy="billet")
     */
    private $commandeVignettes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VenteVignette", mappedBy="billet")
     */
    private $venteVignettes;

    public function __construct()
    {
        $this->commandeVignettes = new ArrayCollection();
        $this->venteVignettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuichet(): ?Guichet
    {
        return $this->guichet;
    }

    public function setGuichet(?Guichet $guichet): self
    {
        $this->guichet = $guichet;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNumeroDernierBillet(): ?int
    {
        return $this->numeroDernierBillet;
    }

    public function setNumeroDernierBillet(int $numeroDernierBillet): self
    {
        $this->numeroDernierBillet = $numeroDernierBillet;

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
     * @return Collection|CommandeVignette[]
     */
    public function getCommandeVignettes(): Collection
    {
        return $this->commandeVignettes;
    }

    public function addCommandeVignette(CommandeVignette $commandeVignette): self
    {
        if (!$this->commandeVignettes->contains($commandeVignette)) {
            $this->commandeVignettes[] = $commandeVignette;
            $commandeVignette->setBillet($this);
        }

        return $this;
    }

    public function removeCommandeVignette(CommandeVignette $commandeVignette): self
    {
        if ($this->commandeVignettes->contains($commandeVignette)) {
            $this->commandeVignettes->removeElement($commandeVignette);
            // set the owning side to null (unless already changed)
            if ($commandeVignette->getBillet() === $this) {
                $commandeVignette->setBillet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VenteVignette[]
     */
    public function getVenteVignettes(): Collection
    {
        return $this->venteVignettes;
    }

    public function addVenteVignette(VenteVignette $venteVignette): self
    {
        if (!$this->venteVignettes->contains($venteVignette)) {
            $this->venteVignettes[] = $venteVignette;
            $venteVignette->setBillet($this);
        }

        return $this;
    }

    public function removeVenteVignette(VenteVignette $venteVignette): self
    {
        if ($this->venteVignettes->contains($venteVignette)) {
            $this->venteVignettes->removeElement($venteVignette);
            // set the owning side to null (unless already changed)
            if ($venteVignette->getBillet() === $this) {
                $venteVignette->setBillet(null);
            }
        }

        return $this;
    }
}
