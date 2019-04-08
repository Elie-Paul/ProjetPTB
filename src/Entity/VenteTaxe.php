<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VenteTaxeRepository")
 */
class VenteTaxe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BilletTaxe", inversedBy="venteTaxes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $billet;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbreDeBillet;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBillet(): ?BilletTaxe
    {
        return $this->billet;
    }

    public function setBillet(?BilletTaxe $billet): self
    {
        $this->billet = $billet;

        return $this;
    }

    public function getNbreDeBillet(): ?int
    {
        return $this->nbreDeBillet;
    }

    public function setNbreDeBillet(int $nbreDeBillet): self
    {
        $this->nbreDeBillet = $nbreDeBillet;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

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
