<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DateRepository")
 */
class Date
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateBillets;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateBillets(): ?\DateTimeInterface
    {
        return $this->dateBillets;
    }

    public function setDateBillets(\DateTimeInterface $dateBillets): self
    {
        $this->dateBillets = $dateBillets;

        return $this;
    }
}
