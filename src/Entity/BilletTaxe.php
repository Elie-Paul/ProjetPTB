<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BilletTaxeRepository")
 */
class BilletTaxe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroDernierBillet;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandeTaxe", mappedBy="billet")
     */
    private $commandeTaxes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StockTaxe", mappedBy="billet")
     */
    private $stockTaxes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VenteTaxe", mappedBy="billet")
     */
    private $venteTaxes;

    public function __construct()
    {
        $this->commandeTaxes = new ArrayCollection();
        $this->stockTaxes = new ArrayCollection();
        $this->venteTaxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

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
     * @return Collection|CommandeTaxe[]
     */
    public function getCommandeTaxes(): Collection
    {
        return $this->commandeTaxes;
    }

    public function addCommandeTax(CommandeTaxe $commandeTax): self
    {
        if (!$this->commandeTaxes->contains($commandeTax)) {
            $this->commandeTaxes[] = $commandeTax;
            $commandeTax->setBillet($this);
        }

        return $this;
    }

    public function removeCommandeTax(CommandeTaxe $commandeTax): self
    {
        if ($this->commandeTaxes->contains($commandeTax)) {
            $this->commandeTaxes->removeElement($commandeTax);
            // set the owning side to null (unless already changed)
            if ($commandeTax->getBillet() === $this) {
                $commandeTax->setBillet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StockTaxe[]
     */
    public function getStockTaxes(): Collection
    {
        return $this->stockTaxes;
    }

    public function addStockTax(StockTaxe $stockTax): self
    {
        if (!$this->stockTaxes->contains($stockTax)) {
            $this->stockTaxes[] = $stockTax;
            $stockTax->setBillet($this);
        }

        return $this;
    }

    public function removeStockTax(StockTaxe $stockTax): self
    {
        if ($this->stockTaxes->contains($stockTax)) {
            $this->stockTaxes->removeElement($stockTax);
            // set the owning side to null (unless already changed)
            if ($stockTax->getBillet() === $this) {
                $stockTax->setBillet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VenteTaxe[]
     */
    public function getVenteTaxes(): Collection
    {
        return $this->venteTaxes;
    }

    public function addVenteTax(VenteTaxe $venteTax): self
    {
        if (!$this->venteTaxes->contains($venteTax)) {
            $this->venteTaxes[] = $venteTax;
            $venteTax->setBillet($this);
        }

        return $this;
    }

    public function removeVenteTax(VenteTaxe $venteTax): self
    {
        if ($this->venteTaxes->contains($venteTax)) {
            $this->venteTaxes->removeElement($venteTax);
            // set the owning side to null (unless already changed)
            if ($venteTax->getBillet() === $this) {
                $venteTax->setBillet(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        
        return 'Taxe:'.$this->getPrix();
        
        
    }
}
