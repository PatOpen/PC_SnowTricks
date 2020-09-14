<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
	 * @ORM\ManyToOne(targetEntity=user::class, inversedBy="tricks")
	 * @ORM\JoinColumn(nullable=false)
	 */
	private ?user $user_id;

	/**
	 * @ORM\OneToMany(targetEntity=Image::class, mappedBy="trick_id")
	 */
	private ArrayCollection $images;

	/**
	 * @ORM\OneToMany(targetEntity=Video::class, mappedBy="trick_id")
	 */
	private ArrayCollection $videos;

	/**
	 * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="trick_id")
	 */
	private ArrayCollection $comments;

	public function __construct()
	{
		$this->create_at = new DateTime( 'now' );
		$this->images    = new ArrayCollection();
		$this->videos    = new ArrayCollection();
		$this->comments  = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle( string $title ): self
	{
		$this->title = $title;

		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription( string $description ): self
	{
		$this->description = $description;

		return $this;
	}

	public function getCreateAt(): ?DateTimeInterface
	{
		return $this->create_at;
	}

	public function setCreateAt( DateTimeInterface $create_at ): self
	{
		$this->create_at = $create_at;

		return $this;
	}

	public function getModifiedAt(): ?DateTimeInterface
	{
		return $this->modified_at;
	}

	public function setModifiedAt( ?DateTimeInterface $modified_at ): self
	{
		$this->modified_at = $modified_at;

		return $this;
	}

	public function getUserId(): ?user
	{
		return $this->user_id;
	}

	public function setUserId( ?user $user_id ): self
	{
		$this->user_id = $user_id;

		return $this;
	}

	/**
	 * @return Collection|Image[]
	 */
	public function getImages(): Collection
	{
		return $this->images;
	}

	public function addImage( Image $image ): self
	{
		if ( ! $this->images->contains( $image ) )
		{
			$this->images[] = $image;
			$image->setTrickId( $this );
		}

		return $this;
	}

	public function removeImage( Image $image ): self
	{
		if ( $this->images->contains( $image ) )
		{
			$this->images->removeElement( $image );
			// set the owning side to null (unless already changed)
			if ( $image->getTrickId() === $this )
			{
				$image->setTrickId( null );
			}
		}

		return $this;
	}

	/**
	 * @return Collection|Video[]
	 */
	public function getVideos(): Collection
	{
		return $this->videos;
	}

	public function addVideo( Video $video ): self
	{
		if ( ! $this->videos->contains( $video ) )
		{
			$this->videos[] = $video;
			$video->setTrickId( $this );
		}

		return $this;
	}

	public function removeVideo( Video $video ): self
	{
		if ( $this->videos->contains( $video ) )
		{
			$this->videos->removeElement( $video );
			// set the owning side to null (unless already changed)
			if ( $video->getTrickId() === $this )
			{
				$video->setTrickId( null );
			}
		}

		return $this;
	}

	/**
	 * @return Collection|Comment[]
	 */
	public function getComments(): Collection
	{
		return $this->comments;
	}

	public function addComment( Comment $comment ): self
	{
		if ( ! $this->comments->contains( $comment ) )
		{
			$this->comments[] = $comment;
			$comment->setTrickId( $this );
		}

		return $this;
	}

	public function removeComment( Comment $comment ): self
	{
		if ( $this->comments->contains( $comment ) )
		{
			$this->comments->removeElement( $comment );
			// set the owning side to null (unless already changed)
			if ( $comment->getTrickId() === $this )
			{
				$comment->setTrickId( null );
			}
		}

		return $this;
	}
}
