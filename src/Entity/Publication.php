<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Builder\Property;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PublicationRepository::class)
 * @Vich\Uploadable()
 */
class Publication
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="publications")
     */
    private $publicateur;

    /**
     * @ORM\ManyToOne(targetEntity=SousCategory::class, inversedBy="publications")
     */
    private $sousCategory;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $disponibilite;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;


    /**
     * @var File|null
     * @Vich\UploadableField(mapping = "product_image", fileNameProperty = "filename")
     */
    private $imageFile;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $filename;

    /**
     * @ORM\Column(type="datetime", nullable = true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=Caddy::class, mappedBy="produit")
     */
    private $caddies;


    public function __construct()
    {
        $this->caddies = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublicateur(): ?User
    {
        return $this->publicateur;
    }

    public function setPublicateur(?User $publicateur): self
    {
        $this->publicateur = $publicateur;

        return $this;
    }

    public function getSousCategory(): ?SousCategory
    {
        return $this->sousCategory;
    }

    public function setSousCategory(?SousCategory $sousCategory): self
    {
        $this->sousCategory = $sousCategory;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(bool $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    /**
     * Get the value of filename
     *
     * @return  string|null
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the value of filename
     *
     * @param  string|null  $filename
     *
     * @return  Property
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get the value of imageFile
     *
     * @return  File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @param  File|null  $imageFile
     *
     * @return  Property
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }


    /**
     * Get the value of visible
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set the value of visible
     *
     * @return  self
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }



    /**
     * @return Collection|Caddy[]
     */
    public function getCaddies(): Collection
    {
        return $this->caddies;
    }

    public function addCaddy(Caddy $caddy): self
    {
        if (!$this->caddies->contains($caddy)) {
            $this->caddies[] = $caddy;
            $caddy->setProduit($this);
        }

        return $this;
    }

    public function removeCaddy(Caddy $caddy): self
    {
        if ($this->caddies->removeElement($caddy)) {
            // set the owning side to null (unless already changed)
            if ($caddy->getProduit() === $this) {
                $caddy->setProduit(null);
            }
        }

        return $this;
    }
}
