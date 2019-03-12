<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TracabiliteRepository")
 */
class Tracabilite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tracabilites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ptb", inversedBy="tracabilites")
     */
    private $ptb;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Navette", inversedBy="tracabilites")
     */
    private $navette;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="text")
     */
    private $motif;

    /**
     * @ORM\Column(type="integer")
     */
    private $numDepart;

    /**
     * @ORM\Column(type="integer")
     */
    private $numFin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPtb(): ?Ptb
    {
        return $this->ptb;
    }

    public function setPtb(?Ptb $ptb): self
    {
        $this->ptb = $ptb;

        return $this;
    }

    public function getNavette(): ?Navette
    {
        return $this->navette;
    }

    public function setNavette(?Navette $navette): self
    {
        $this->navette = $navette;

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

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getNumDepart(): ?int
    {
        return $this->numDepart;
    }

    public function setNumDepart(int $numDepart): self
    {
        $this->numDepart = $numDepart;

        return $this;
    }

    public function getNumFin(): ?int
    {
        return $this->numFin;
    }

    public function setNumFin(int $numFin): self
    {
        $this->numFin = $numFin;

        return $this;
    }
}
