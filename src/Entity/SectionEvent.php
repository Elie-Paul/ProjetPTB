<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SectionEventRepository")
 * @UniqueEntity("libelle", message="Le libelle saisi existe dejà")
 * @UniqueEntity("prix", message="Deux sections ne peuvent pas avoir le même prix")
 */
class SectionEvent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 5000
     * )
     */
    private $prix;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrajetEvent", mappedBy="secton", orphanRemoval=true)
     */
    private $trajetEvents;

    public function __construct()
    {
        $this->trajetEvents = new ArrayCollection();
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
     * @return Collection|TrajetEvent[]
     */
    public function getTrajetEvents(): Collection
    {
        return $this->trajetEvents;
    }

    public function addTrajetEvent(TrajetEvent $trajetEvent): self
    {
        if (!$this->trajetEvents->contains($trajetEvent)) {
            $this->trajetEvents[] = $trajetEvent;
            $trajetEvent->setSecton($this);
        }

        return $this;
    }

    public function removeTrajetEvent(TrajetEvent $trajetEvent): self
    {
        if ($this->trajetEvents->contains($trajetEvent)) {
            $this->trajetEvents->removeElement($trajetEvent);
            // set the owning side to null (unless already changed)
            if ($trajetEvent->getSecton() === $this) {
                $trajetEvent->setSecton(null);
            }
        }

        return $this;
    }

}
