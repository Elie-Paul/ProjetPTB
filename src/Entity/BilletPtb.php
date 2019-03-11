<?php

namespace App\Entity;

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
     * @ORM\OneToOne(targetEntity="App\Entity\Ptb", inversedBy="billetPtb", cascade={"persist", "remove"})
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPtb(): ?Ptb
    {
        return $this->ptb;
    }

    public function setPtb(?PTB $ptb): self
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
}
