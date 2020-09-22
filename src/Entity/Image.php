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
	private $alt_image;

    /**
     * @ORM\Column(type="string", length=255)
     */
	private $image_name;

    /**
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="images")
     */
	private ?Trick $trick;

    public function getId(): ?int
    {
        return $this->id;
    }

	/**
	 * @return string|null
	 */
    public function getAltImage(): ?string
    {
        return $this->alt_image;
    }

	/**
	 * @param string|null $alt_image
	 *
	 * @return $this
	 */
    public function setAltImage(?string $alt_image): self
    {
        $this->alt_image = $alt_image;

        return $this;
    }

	/**
	 * @return string|null
	 */
    public function getImageName(): ?string
    {
        return $this->image_name;
    }

	/**
	 * @param ?string $image_name
	 *
	 * @return $this
	 */
    public function setImageName(?string $image_name): self
    {
        $this->image_name = $image_name;

        return $this;
    }

	/**
	 * @return Trick|null
	 */
    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

	/**
	 * @param Trick|null $trick
	 *
	 * @return $this
	 */
    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }
}
