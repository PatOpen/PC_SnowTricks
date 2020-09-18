<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository", repositoryClass=VideoRepository::class)
 */
class Video
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
	private ?string $alt_video;

    /**
     * @ORM\Column(type="string", length=255)
     */
	private ?string $url_video;

    /**
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="videos")
     */
	private ?trick $trick;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAltVideo(): ?string
    {
        return $this->alt_video;
    }

    public function setAltVideo(?string $alt_video): self
    {
        $this->alt_video = $alt_video;

        return $this;
    }

    public function getUrlVideo(): ?string
    {
        return $this->url_video;
    }

    public function setUrlVideo(string $url_video): self
    {
        $this->url_video = $url_video;

        return $this;
    }

    public function getTrick(): ?trick
    {
        return $this->trick;
    }

    public function setTrick(?trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }
}
