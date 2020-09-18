<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin
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
     * @ORM\Column(type="string", length=255)
     */
	private ?string $role;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
	private ?User $user;

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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
