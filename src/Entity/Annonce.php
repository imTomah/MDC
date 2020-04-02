<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnnonceRepository")
 * @Vich\Uploadable
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

    // Import de l'image 

    /**
     * 
     * @var File|null
     * @Assert\Image(
     *      mimeTypes="image/jpeg"
     * )
     * @Vich\UploadableField(mapping="annonce_image", fileNameProperty="filename")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string|null
     */
    private $filename;

    /**
     * @ORM\Column(type="datetime")
     */
    private $UpdatedAt;


    public function __construct() 
    {
        $dateNow = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->setUpdatedAt($dateNow);
    }

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

    // Getter - Setter Image upload

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     * @return Annonce
     */
    public function setFilename(?string $filename): Annonce
    {
        $this->filename = $filename;
        if ($this->filename instanceof UploadedFile){
            $this->UpdatedAt= new \DateTime('now');
        }
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile() : ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return Annonce
     */
    public function setImageFile(?File $imageFile): Annonce
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }
}
