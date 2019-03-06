<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GuichetRepository")
 */
class Guichet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieux", inversedBy="guichets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieu;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BilletPtb", mappedBy="guichet")
     */
    private $billetPtbs;

    public function __construct()
    {
        $this->billetPtbs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLieu(): ?Lieux
    {
        return $this->lieu;
    }

    public function setLieu(?Lieux $lieu): self
    {
        $this->lieu = $lieu;

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
            $billetPtb->setGuichet($this);
        }

        return $this;
    }

    public function removeBilletPtb(BilletPtb $billetPtb): self
    {
        if ($this->billetPtbs->contains($billetPtb)) {
            $this->billetPtbs->removeElement($billetPtb);
            // set the owning side to null (unless already changed)
            if ($billetPtb->getGuichet() === $this) {
                $billetPtb->setGuichet(null);
            }
        }

        return $this;
    }
}
