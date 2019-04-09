<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LieuxRepository")
 * @UniqueEntity("libelle")
 */
class Lieux
{
    /**
     * @ORM\Id()use App\
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=35)
     * @Assert\Regex(pattern="/^[a-zA-Z0-9 ]+$/", match=true, message="Les caractères spéciaux sont interdits dans le titre")
     */
    private $libelle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trajet", mappedBy="depart")
     */
    private $trajetsDepart;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trajet", mappedBy="arrivee")
     */
    private $trajetsArrivee;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Guichet", mappedBy="lieu")
     */
    private $guichets;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\TrajetEvent", mappedBy="depart", cascade={"persist", "remove"})
     */
    private $trajetEventDepart;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\TrajetEvent", mappedBy="arrivee", cascade={"persist", "remove"})
     */
    private $trajetEventArrivee;

    public function __construct()
    {
        $this->trajetsDepart = new ArrayCollection();
        $this->trajetsArrivee = new ArrayCollection();
        $this->guichets = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
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
     * @return Collection|Trajet[]
     */
    public function getTrajetsDepart(): Collection
    {
        return $this->trajetsDepart;
    }

    public function addTrajetsDepart(Trajet $trajetsDepart): self
    {
        if (!$this->trajetsDepart->contains($trajetsDepart)) {
            $this->trajetsDepart[] = $trajetsDepart;
            $trajetsDepart->setDepart($this);
        }

        return $this;
    }

    public function removeTrajetsDepart(Trajet $trajetsDepart): self
    {
        if ($this->trajetsDepart->contains($trajetsDepart)) {
            $this->trajetsDepart->removeElement($trajetsDepart);
            // set the owning side to null (unless already changed)
            if ($trajetsDepart->getDepart() === $this) {
                $trajetsDepart->setDepart(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Trajet[]
     */
    public function getTrajetsArrivee(): Collection
    {
        return $this->trajetsArrivee;
    }

    public function addTrajetsArrivee(Trajet $trajetsArrivee): self
    {
        if (!$this->trajetsArrivee->contains($trajetsArrivee)) {
            $this->trajetsArrivee[] = $trajetsArrivee;
            $trajetsArrivee->setArrivee($this);
        }

        return $this;
    }

    public function removeTrajetsArrivee(Trajet $trajetsArrivee): self
    {
        if ($this->trajetsArrivee->contains($trajetsArrivee)) {
            $this->trajetsArrivee->removeElement($trajetsArrivee);
            // set the owning side to null (unless already changed)
            if ($trajetsArrivee->getArrivee() === $this) {
                $trajetsArrivee->setArrivee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Guichet[]
     */
    public function getGuichets(): Collection
    {
        return $this->guichets;
    }

    public function addGuichet(Guichet $guichet): self
    {
        if (!$this->guichets->contains($guichet)) {
            $this->guichets[] = $guichet;
            $guichet->setLieu($this);
        }

        return $this;
    }

    public function removeGuichet(Guichet $guichet): self
    {
        if ($this->guichets->contains($guichet)) {
            $this->guichets->removeElement($guichet);
            // set the owning side to null (unless already changed)
            if ($guichet->getLieu() === $this) {
                $guichet->setLieu(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string)$this->libelle;
    }

    public function getTrajetEventDepart(): ?TrajetEvent
    {
        return $this->trajetEventDepart;
    }

    public function setTrajetEventDepart(TrajetEvent $trajetEventDepart): self
    {
        $this->trajetEventDepart = $trajetEventDepart;

        // set the owning side of the relation if necessary
        if ($this !== $trajetEventDepart->getDepart()) {
            $trajetEventDepart->setDepart($this);
        }

        return $this;
    }

    public function getTrajetEventArrivee(): ?TrajetEvent
    {
        return $this->trajetEventArrivee;
    }

    public function setTrajetEventArrivee(TrajetEvent $trajetEventArrivee): self
    {
        $this->trajetEventArrivee = $trajetEventArrivee;

        // set the owning side of the relation if necessary
        if ($this !== $trajetEventArrivee->getArrivee()) {
            $trajetEventArrivee->setArrivee($this);
        }

        return $this;
    }
}
