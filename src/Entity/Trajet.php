<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrajetRepository")
 */
class Trajet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieux", inversedBy="trajetsDepart")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotEqualTo(propertyPath="arrivee", message="Le lieu de depart doit être different du lieu d'arrivé !!!")
     */
    private $depart;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieux", inversedBy="trajetsArrivee")
     * @ORM\JoinColumn(nullable=false)
     */
    private $arrivee;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Navette", mappedBy="trajet", cascade={"persist", "remove"})
     */
    private $navette;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ptb", mappedBy="trajet", cascade={"persist", "remove"})
     */
    private $ptb;
    private $trajetlib;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Evenement", inversedBy="trajetEvent")
     */
    private $evenement;
    public function __construct()
    {
        $this->navette = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepart(): ?Lieux
    {
        return $this->depart;
    }

    public function setDepart(?Lieux $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getArrivee(): ?Lieux
    {
        return $this->arrivee;
    }

    public function setArrivee(?Lieux $arrivee): self
    {
        $this->arrivee = $arrivee;

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

    public function getNavette(): ?Navette
    {
        return $this->navette;
    }

    public function setNavette(Navette $navette): self
    {
        $this->navette = $navette;

        // set the owning side of the relation if necessary
        if ($this !== $navette->getTrajet()) {
            $navette->setTrajet($this);
        }

        return $this;
    }

    public function getPtb(): ?Ptb
    {
        return $this->ptb;
    }

    public function setPtb(Ptb $ptb): self
    {
        $this->ptb = $ptb;

        // set the owning side of the relation if necessary
        if ($this !== $ptb->getTrajet()) {
            $ptb->setTrajet($this);
        }

        return $this;
    }

    public function __toString()
    {
        return (string)$this->depart->getLibelle().'-'.$this->arrivee->getLibelle();
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }

    
}
