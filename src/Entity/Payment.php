<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaymentRepository")
 */
class Payment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $annee;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mois;

    public const MOIS = [
      'Janvier' => 'Janvier',
      'Fevrier' => 'Fevrier',
      'Mars' => 'Mars',
      'Avril' => 'Avril',
      'Mai' => 'Mais',
      'Juin' => 'Juin',
      'Juillet' => 'Juillet',
      'Aout' => 'Aout',
      'Septembre' => 'Septembre',
      'Octobre' => 'Octobre',
      'Novembre' => 'Novembre',
      'Decembre' => 'Decembre'
    ];
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Abonnement", inversedBy="payments")
     */
    private $abonnement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(string $mois): self
    {
        $this->mois = $mois;

        return $this;
    }

    public function getAbonnement(): ?Abonnement
    {
        return $this->abonnement;
    }

    public function setAbonnement(?Abonnement $abonnement): self
    {
        $this->abonnement = $abonnement;

        return $this;
    }
}
