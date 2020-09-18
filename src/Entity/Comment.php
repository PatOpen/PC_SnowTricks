<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
	private ?int $id;

    /**
     * @ORM\Column(type="datetime")
     */
	private ?DateTimeInterface $create_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
	private ?DateTimeInterface $modified_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
	private ?string $content;

    /**
     * @ORM\Column(type="boolean")
     */
	private ?bool $validation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     */
	private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="comments")
     */
	private ?Trick $trick;

	public function __construct()
	{
		$this->create_at = new DateTime( 'now' );
	}

	public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getValidation(): ?bool
    {
        return $this->validation;
    }

    public function setValidation(bool $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

	/**
	 * @param ?User $user
	 *
	 * @return $this
	 */
	public function setUser(?User $user): ?self
    {
        $this->user = $user;

        return $this;
    }

    public function getTrick(): Trick
    {
        return $this->trick;
    }

    public function setTrick(Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }
}
