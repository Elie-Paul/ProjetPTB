<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeNavetteRepository")
 */
class CommandeNavette
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BilletNavette", inversedBy="commandeNavettes")
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
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateComnandeValider;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateCommandeRealiser;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreBilletVendu;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreBilletRealise;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBillet(): ?BilletNavette
    {
        return $this->billet;
    }

    public function setBillet(?BilletNavette $billet): self
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

    public function getDateComnandeValider(): ?\DateTimeInterface
    {
        return $this->dateComnandeValider;
    }

    public function setDateComnandeValider(\DateTimeInterface $dateComnandeValider): self
    {
        $this->dateComnandeValider = $dateComnandeValider;

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

    public function getNombreBilletVendu(): ?int
    {
        return $this->nombreBilletVendu;
    }

    public function setNombreBilletVendu(int $nombreBilletVendu): self
    {
        $this->nombreBilletVendu = $nombreBilletVendu;

        return $this;
    }

    public function getNombreBilletRealise(): ?int
    {
        return $this->nombreBilletRealise;
    }

    public function setNombreBilletRealise(int $nombreBilletRealise): self
    {
        $this->nombreBilletRealise = $nombreBilletRealise;

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
}
