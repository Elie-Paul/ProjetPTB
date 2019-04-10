<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
 * @UniqueEntity("libelle", message="L'évènment existe dejà")
 */
class Evenement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrajetEvent", mappedBy="evenement", orphanRemoval=true)
     */
    private $trajet;

//    /**
//     * @ORM\OneToMany(targetEntity="App\Entity\SectionEvent", mappedBy="evenement", orphanRemoval=true)
//     */
//    private $section;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEvent;

    /**
     * @ORM\Column(type="date")
     */
    private $finEvent;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $UpdatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BilletPtb", mappedBy="evenement")
     */
    private $billetPtbs;

    public function __construct()
    {
        $this->trajet = new ArrayCollection();
        $this->billetPtbs = new ArrayCollection();
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

    /**
     * @return Collection|TrajetEvent[]
     */
    public function getTrajet(): Collection
    {
        return $this->trajet;
    }

    public function addTrajet(TrajetEvent $trajet): self
    {
        if (!$this->trajet->contains($trajet)) {
            $this->trajet[] = $trajet;
            $trajet->setEvenement($this);
        }

        return $this;
    }

    public function removeTrajet(TrajetEvent $trajet): self
    {
        if ($this->trajet->contains($trajet)) {
            $this->trajet->removeElement($trajet);
            // set the owning side to null (unless already changed)
            if ($trajet->getEvenement() === $this) {
                $trajet->setEvenement(null);
            }
        }

        return $this;
    }


    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTimeInterface $dateEvent): self
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function getFinEvent(): ?\DateTimeInterface
    {
        return $this->finEvent;
    }

    public function setFinEvent(\DateTimeInterface $finEvent): self
    {
        $this->finEvent = $finEvent;

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
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    /**
     * @return Collection|BilletPtb[]
     */
    public function getBilletPtbs(): Collection
    {
        return $this->billetPtbs;
    }

    public function addBilletPtb(BilletPtb $billetPtb): self
    {
        if (!$this->billetPtbs->contains($billetPtb)) {
            $this->billetPtbs[] = $billetPtb;
            $billetPtb->setEvenement($this);
        }

        return $this;
    }

    public function removeBilletPtb(BilletPtb $billetPtb): self
    {
        if ($this->billetPtbs->contains($billetPtb)) {
            $this->billetPtbs->removeElement($billetPtb);
            // set the owning side to null (unless already changed)
            if ($billetPtb->getEvenement() === $this) {
                $billetPtb->setEvenement(null);
            }
        }

        return $this;
    }

}
