<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BilletPtbRepository")
 */
class BilletPtb
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ptb", inversedBy="billetPtb", cascade={"persist", "remove"})
     */
    private $ptb;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Guichet", inversedBy="billetPtbs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $guichet;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroDernierBillets;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandePtb", mappedBy="billet")
     */
    private $commandePtbs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VentePtb", mappedBy="billet")
     */
    private $ventePtbs;

    public function __construct()
    {
        $this->commandePtbs = new ArrayCollection();
        $this->ventePtbs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getGuichet(): ?Guichet
    {
        return $this->guichet;
    }

    public function setGuichet(?Guichet $guichet): self
    {
        $this->guichet = $guichet;

        return $this;
    }

    public function getNumeroDernierBillets(): ?int
    {
        return $this->numeroDernierBillets;
    }

    public function setNumeroDernierBillets(int $numeroDernierBillets): self
    {
        $this->numeroDernierBillets = $numeroDernierBillets;

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

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function __toString()
    {
        return $this->getGuichet()+' '+$this->getPtb()->getTrajet()->getDepart();
    }

    /**
     * @return Collection|CommandePtb[]
     */
    public function getCommandePtbs(): Collection
    {
        return $this->commandePtbs;
    }

    public function addCommandePtb(CommandePtb $commandePtb): self
    {
        if (!$this->commandePtbs->contains($commandePtb)) {
            $this->commandePtbs[] = $commandePtb;
            $commandePtb->setBillet($this);
        }

        return $this;
    }

    public function removeCommandePtb(CommandePtb $commandePtb): self
    {
        if ($this->commandePtbs->contains($commandePtb)) {
            $this->commandePtbs->removeElement($commandePtb);
            // set the owning side to null (unless already changed)
            if ($commandePtb->getBillet() === $this) {
                $commandePtb->setBillet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VentePtb[]
     */
    public function getVentePtbs(): Collection
    {
        return $this->ventePtbs;
    }

    public function addVentePtb(VentePtb $ventePtb): self
    {
        if (!$this->ventePtbs->contains($ventePtb)) {
            $this->ventePtbs[] = $ventePtb;
            $ventePtb->setBillet($this);
        }

        return $this;
    }

    public function removeVentePtb(VentePtb $ventePtb): self
    {
        if ($this->ventePtbs->contains($ventePtb)) {
            $this->ventePtbs->removeElement($ventePtb);
            // set the owning side to null (unless already changed)
            if ($ventePtb->getBillet() === $this) {
                $ventePtb->setBillet(null);
            }
        }

        return $this;
    }


}
