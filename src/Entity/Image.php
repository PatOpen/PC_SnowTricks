<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
	private ?int $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
	private ?string $alt_image;

    /**
     * @ORM\Column(type="string", length=255)
     */
	private ?string $image_name;

    /**
     * @ORM\ManyToOne(targetEntity=trick::class, inversedBy="images")
     */
	private ?trick $trick_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAltImage(): ?string
    {
        return $this->alt_image;
    }

    public function setAltImage(?string $alt_image): self
    {
        $this->alt_image = $alt_image;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->image_name;
    }

    public function setImageName(string $image_name): self
    {
        $this->image_name = $image_name;

        return $this;
    }

    public function getTrickId(): ?trick
    {
        return $this->trick_id;
    }

    public function setTrickId(?trick $trick_id): self
    {
        $this->trick_id = $trick_id;

        return $this;
    }
}
