<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=35)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tracabilite", mappedBy="user")
     */
    private $tracabilites;

    public function __construct()
    {
        $this->tracabilites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Tracabilite[]
     */
    public function getTracabilites(): Collection
    {
        return $this->tracabilites;
    }

    public function addTracabilite(Tracabilite $tracabilite): self
    {
        if (!$this->tracabilites->contains($tracabilite)) {
            $this->tracabilites[] = $tracabilite;
            $tracabilite->setUser($this);
        }

        return $this;
    }

    public function removeTracabilite(Tracabilite $tracabilite): self
    {
        if ($this->tracabilites->contains($tracabilite)) {
            $this->tracabilites->removeElement($tracabilite);
            // set the owning side to null (unless already changed)
            if ($tracabilite->getUser() === $this) {
                $tracabilite->setUser(null);
            }
        }

        return $this;
    }
}
