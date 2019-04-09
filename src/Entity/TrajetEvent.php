<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrajetEventRepository")
 */
class TrajetEvent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

//    /**
//     * @ORM\Column(type="string", length=255)
//     */
//    private $depart;
//
//    /**
//     * @ORM\Column(type="string", length=255)
//     */
//    private $arrivee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Evenement", inversedBy="trajet")
     * @ORM\JoinColumn(nullable=true)
     */
    private $evenement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SectionEvent", inversedBy="trajetEvents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $section;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\BilletEvent", mappedBy="trajet", cascade={"persist", "remove"})
     */
    private $billetEvent;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Lieux", inversedBy="trajetEventDepart", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $depart;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Lieux", inversedBy="trajetEventArrivee", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $arrivee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepart(): ?string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getArrivee(): ?string
    {
        return $this->arrivee;
    }

    public function setArrivee(string $arrivee): self
    {
        $this->arrivee = $arrivee;

        return $this;
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

    public function __toString()
    {
        return $this->getDepart().'-'.$this->getArrivee();
    }

    /**
     * @return mixed
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param mixed $section
     */
    public function setSection($section): void
    {
        $this->section = $section;
    }

    public function getBilletEvent(): ?BilletEvent
    {
        return $this->billetEvent;
    }

    public function setBilletEvent(BilletEvent $billetEvent): self
    {
        $this->billetEvent = $billetEvent;

        // set the owning side of the relation if necessary
        if ($this !== $billetEvent->getTrajet()) {
            $billetEvent->setTrajet($this);
        }

        return $this;
    }

}
