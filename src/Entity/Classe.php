<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClasseRepository")
 */
class Classe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $libelle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Navette", mappedBy="classe")
     */
    private $navettes;

    public function __construct()
    {
        $this->navettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
     * @return Collection|Navette[]
     */
    public function getNavettes(): Collection
    {
        return $this->navettes;
    }

    public function addNavette(Navette $navette): self
    {
        if (!$this->navettes->contains($navette)) {
            $this->navettes[] = $navette;
            $navette->setClasse($this);
        }

        return $this;
    }

    public function removeNavette(Navette $navette): self
    {
        if ($this->navettes->contains($navette)) {
            $this->navettes->removeElement($navette);
            // set the owning side to null (unless already changed)
            if ($navette->getClasse() === $this) {
                $navette->setClasse(null);
            }
        }

        return $this;
    }
}
