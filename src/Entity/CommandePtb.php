<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandePtbRepository")
 */
class CommandePtb
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BilletPtb", inversedBy="commandePtbs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $billet;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreBillet;

    /**
     * @ORM\Column(type="integer")
     */
    private $etatCommande;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCommande;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCommandeValider;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCommandeRealiser;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBillet(): ?BilletPtb
    {
        return $this->billet;
    }

    public function setBillet(?BilletPtb $billet): self
    {
        $this->billet = $billet;

        return $this;
    }

    public function getNombreBillet(): ?int
    {
        return $this->nombreBillet;
    }

    public function setNombreBillet(int $nombreBillet): self
    {
        $this->nombreBillet = $nombreBillet;

        return $this;
    }

    public function getEtatCommande(): ?int
    {
        return $this->etatCommande;
    }

    public function setEtatCommande(int $etatCommande): self
    {
        $this->etatCommande = $etatCommande;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getDateCommandeValider(): ?\DateTimeInterface
    {
        return $this->dateCommandeValider;
    }

    public function setDateCommandeValider(\DateTimeInterface $dateCommandeValider): self
    {
        $this->dateCommandeValider = $dateCommandeValider;

        return $this;
    }

    public function getDateCommandeRealiser(): ?\DateTimeInterface
    {
        return $this->dateCommandeRealiser;
    }

    public function setDateCommandeRealiser(\DateTimeInterface $dateCommandeRealiser): self
    {
        $this->dateCommandeRealiser = $dateCommandeRealiser;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
