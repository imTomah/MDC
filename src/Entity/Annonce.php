<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnnonceRepository")
 */
class Annonce
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Title;

    /**
     * @ORM\Column(type="text")
     */
    private $Content;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $Quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departement", inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="annonces")
     */
    private $Author;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->Quantity;
    }

    public function setQuantity(?float $Quantity): self
    {
        $this->Quantity = $Quantity;

        return $this;
    }

    public function getLocation(): ?Departement
    {
        return $this->Location;
    }

    public function setLocation(?Departement $Location): self
    {
        $this->Location = $Location;

        return $this;
    }

    public function getType(): ?Category
    {
        return $this->Type;
    }

    public function setType(?Category $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->Author;
    }

    public function setAuthor(?User $Author): self
    {
        $this->Author = $Author;

        return $this;
    }
}
