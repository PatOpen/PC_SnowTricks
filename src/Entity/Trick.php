<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrickRepository::class)
 */
class Trick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
	private ?int $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
	private ?string $title;

    /**
     * @ORM\Column(type="text")
     */
	private ?string $description;

    /**
     * @ORM\Column(type="datetime")
     */
	private ?DateTimeInterface $create_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
	private ?DateTimeInterface $modified_at;

    /**
     * @ORM\Column(type="integer")
     */
	private ?int $user_id;

	public function __construct()
	{
		$this->create_at = new DateTime('now');
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getCreateAt(): ?DateTimeInterface
    {
        return $this->create_at;
    }

    public function setCreateAt( DateTimeInterface $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getModifiedAt(): ?DateTimeInterface
    {
        return $this->modified_at;
    }

    public function setModifiedAt(?DateTimeInterface $modified_at): self
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
}
