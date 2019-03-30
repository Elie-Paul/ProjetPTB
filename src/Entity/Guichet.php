<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GuichetRepository")
 * @UniqueEntity("code")
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
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Votre code doit avoir au minimum {{ limit }} charactère de longueur"
     * )
     * @Assert\Type("string")
     * @Assert\Regex(pattern="/^[a-zA-Z0-9 ]+$/", match=true, message="Les caractères spéciaux sont interdits dans le titre")
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "Votre nom doit avoir au minimum 2 charactère de longueur"
     * )
     * @Assert\Type("string")
     * @Assert\Regex(pattern="/^[a-zA-Z]+$/", match=true, message="Les caractères spéciaux sont interdits dans le titre")
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
     * @ORM\OneToMany(targetEntity="BilletPtb", mappedBy="guichet")
     */
    private $billetPtbs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BilletNavette", mappedBy="guichet")
     */
    private $billetNavettes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vignette", mappedBy="guichet")
     */
    private $vignettes;

    public function __construct()
    {
        $this->billetPtbs = new ArrayCollection();
        $this->billetNavettes = new ArrayCollection();
        $this->vignettes = new ArrayCollection();
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

    /**
     * @return Collection|BilletNavette[]
     */
    public function getBilletNavettes(): Collection
    {
        return $this->billetNavettes;
    }

    public function addBilletNavette(BilletNavette $billetNavette): self
    {
        if (!$this->billetNavettes->contains($billetNavette)) {
            $this->billetNavettes[] = $billetNavette;
            $billetNavette->setGuichet($this);
        }

        return $this;
    }

    public function removeBilletNavette(BilletNavette $billetNavette): self
    {
        if ($this->billetNavettes->contains($billetNavette)) {
            $this->billetNavettes->removeElement($billetNavette);
            // set the owning side to null (unless already changed)
            if ($billetNavette->getGuichet() === $this) {
                $billetNavette->setGuichet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Vignette[]
     */
    public function getVignettes(): Collection
    {
        return $this->vignettes;
    }

    public function addVignette(Vignette $vignette): self
    {
        if (!$this->vignettes->contains($vignette)) {
            $this->vignettes[] = $vignette;
            $vignette->setGuichet($this);
        }

        return $this;
    }

    public function removeVignette(Vignette $vignette): self
    {
        if ($this->vignettes->contains($vignette)) {
            $this->vignettes->removeElement($vignette);
            // set the owning side to null (unless already changed)
            if ($vignette->getGuichet() === $this) {
                $vignette->setGuichet(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string)$this->nom;
    }
}
