<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PtbRepository")
 */
class Ptb
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Trajet", inversedBy="ptb", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $trajet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Section", inversedBy="ptbs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $section;

     /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\BilletPtb", mappedBy="ptb", cascade={"persist", "remove"})
     */
    private $billetPtb;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tracabilite", mappedBy="ptb")
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

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

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

    public function getBilletPtb(): ?BilletPtb
    {
        return $this->billetPtb;
    }

    public function setBilletPtb(?BilletPtb $billetPtb): self
    {
        $this->billetPtb = $billetPtb;

        // set (or unset) the owning side of the relation if necessary
        $newPtb = $billetPtb === null ? null : $this;
        if ($newPtb !== $billetPtb->getPtb()) {
            $billetPtb->setPtb($newPtb);
        }

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
            $tracabilite->setPtb($this);
        }

        return $this;
    }

    public function removeTracabilite(Tracabilite $tracabilite): self
    {
        if ($this->tracabilites->contains($tracabilite)) {
            $this->tracabilites->removeElement($tracabilite);
            // set the owning side to null (unless already changed)
            if ($tracabilite->getPtb() === $this) {
                $tracabilite->setPtb(null);
            }
        }

        return $this;
    }
}
