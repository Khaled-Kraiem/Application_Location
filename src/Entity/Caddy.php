<?php

namespace App\Entity;

use App\Repository\CaddyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CaddyRepository::class)
 */
class Caddy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="caddies")
     */
    private $locateur;

    /**
     * @ORM\ManyToOne(targetEntity=Publication::class, inversedBy="caddies")
     */
    private $produit;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;


    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocateur(): ?User
    {
        return $this->locateur;
    }

    public function setLocateur(?User $locateur): self
    {
        $this->locateur = $locateur;

        return $this;
    }

    public function __toString()
    {
        return $this->locateur;
    }

    public function getProduit(): ?Publication
    {
        return $this->produit;
    }

    public function setProduit(?Publication $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
