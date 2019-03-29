<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BilletEventRepository")
 * @UniqueEntity("trajet", message="Il existe dejà un billet pour ce trajet")
 */
class BilletEvent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\TrajetEvent", inversedBy="billetEvent", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $trajet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Guichet", inversedBy="billetEvents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $guichet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrajet(): ?TrajetEvent
    {
        return $this->trajet;
    }

    public function setTrajet(TrajetEvent $trajet): self
    {
        $this->trajet = $trajet;

        return $this;
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
}
