<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BilletNavetteRepository")
 */
class BilletNavette
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Navette", inversedBy="billetNavette", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $navette;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Guichet", inversedBy="billetNavettes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $guichet;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroDernierBillet;

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

    public function getNavette(): ?Navette
    {
        return $this->navette;
    }

    public function setNavette(Navette $navette): self
    {
        $this->navette = $navette;

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

    public function getNumeroDernierBillet(): ?int
    {
        return $this->numeroDernierBillet;
    }

    public function setNumeroDernierBillet(int $numeroDernierBillet): self
    {
        $this->numeroDernierBillet = $numeroDernierBillet;

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
