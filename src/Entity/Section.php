<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SectionRepository")
 * @UniqueEntity("libelle")
 */
class Section
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Type("string")
     * @Assert\Regex(pattern="/^[a-zA-Z0-9 ]+$/", match=true, message="Les caractères spéciaux sont interdits dans le titre")
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 5000
     * )
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
     * @ORM\OneToMany(targetEntity="App\Entity\Ptb", mappedBy="section")
     */
    private $ptbs;

    public function __construct()
    {
        $this->ptbs = new ArrayCollection();
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
     * @return Collection|Ptb[]
     */
    public function getPtbs(): Collection
    {
        return $this->ptbs;
    }

    public function addPtb(Ptb $ptb): self
    {
        if (!$this->ptbs->contains($ptb)) {
            $this->ptbs[] = $ptb;
            $ptb->setSection($this);
        }

        return $this;
    }

    public function removePtb(Ptb $ptb): self
    {
        if ($this->ptbs->contains($ptb)) {
            $this->ptbs->removeElement($ptb);
            // set the owning side to null (unless already changed)
            if ($ptb->getSection() === $this) {
                $ptb->setSection(null);
            }
        }

        return $this;
    }
}
