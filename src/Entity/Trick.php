<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TrickRepository::class)
 * @UniqueEntity(fields={"title"}, message="Ce titre existe déja !")
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
	 * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tricks", cascade={"persist"})
	 * @ORM\JoinColumn(nullable=false)
	 */
	private $user;

	/**
	 * @ORM\OneToMany(targetEntity=Image::class, mappedBy="trick", orphanRemoval=true, cascade={"persist", "remove"})
	 */
	private Collection $images;

	/**
	 * @ORM\OneToMany(targetEntity=Video::class, mappedBy="trick", orphanRemoval=true, cascade={"persist", "remove"})
	 */
	private Collection $videos;

	/**
	 * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="trick", orphanRemoval=true, cascade={"persist", "remove"})
	 * @ORM\OrderBy({"create_at"="DESC"})
	 */
	private Collection $comments;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="trick")
     */
    private $category;

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

	/**
	 * @return User
	 */
	public function getUser(): User
         	{
         		return $this->user;
         	}

	/**
	 * @param ?User $user
	 *
	 * @return $this
	 */
	public function setUser( ?User $user ): ?self
         	{
         		$this->user = $user;
         
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
         			$image->setTrick( $this );
         		}
         
         		return $this;
         	}

	public function removeImage( Image $image ): self
         	{
         		if ( $this->images->contains( $image ) )
         		{
         			$this->images->removeElement( $image );
         			// set the owning side to null (unless already changed)
         			if ( $image->getTrick() === $this )
         			{
         				$image->setTrick( null );
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
         			$video->setTrick( $this );
         		}
         
         		return $this;
         	}

	public function removeVideo( Video $video ): self
         	{
         		if ( $this->videos->contains( $video ) )
         		{
         			$this->videos->removeElement( $video );
         			// set the owning side to null (unless already changed)
         			if ( $video->getTrick() === $this )
         			{
         				$video->setTrick( null );
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

	/**
	 * @param Comment $comment
	 *
	 * @return $this
	 */
	public function addComment( Comment $comment ): self
         	{
         		if ( ! $this->comments->contains( $comment ) )
         		{
         			$this->comments[] = $comment;
         			$comment->setTrick( $this );
         		}
         
         		return $this;
         	}

	public function removeComment( Comment $comment ): self
         	{
         		if ( $this->comments->contains( $comment ) )
         		{
         			$this->comments->removeElement( $comment );
         			// set the owning side to null (unless already changed)
         			if ( $comment->getTrick() === $this )
         			{
         				$comment->setTrick( null );
         			}
         		}
         
         		return $this;
         	}

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
