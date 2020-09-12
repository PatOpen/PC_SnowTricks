<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 */
class Video
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $trick_id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $alt_video;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url_video;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrickId(): ?int
    {
        return $this->trick_id;
    }

    public function setTrickId(int $trick_id): self
    {
        $this->trick_id = $trick_id;

        return $this;
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
}
