<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeAuditRepository")
 */
class TypeAudit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Audit", mappedBy="typeAudit")
     */
    private $audit;

    public function __construct()
    {
        $this->audit = new ArrayCollection();
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

    /**
     * @return Collection|Audit[]
     */
    public function getAudit(): Collection
    {
        return $this->audit;
    }

    public function addAudit(Audit $audit): self
    {
        if (!$this->audit->contains($audit)) {
            $this->audit[] = $audit;
            $audit->setTypeAudit($this);
        }

        return $this;
    }

    public function removeAudit(Audit $audit): self
    {
        if ($this->audit->contains($audit)) {
            $this->audit->removeElement($audit);
            // set the owning side to null (unless already changed)
            if ($audit->getTypeAudit() === $this) {
                $audit->setTypeAudit(null);
            }
        }

        return $this;
    }
}
