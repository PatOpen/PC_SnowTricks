<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository", repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"pseudo"}, message="Ce pseudo existe déja !")
 * @UniqueEntity(fields={"email"}, message="Cet email existe déja !")
 */
class User implements UserInterface, Serializable
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private ?int $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private ?string $pseudo;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private ?string $firstname;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private ?string $lastname;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Email()
	 */
	private ?string $email;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @Assert\Length(min="4", minMessage="Votre mot de passe doit contenir minimum 4 caractères")
	 */
	private ?string $password;

	/**
	 * @var string|null
	 * @Assert\EqualTo(propertyPath="password", message="Les mots de passe sont différents")
	 */
	private ?string $confirm_password;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private ?DateTimeInterface $create_at;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private ?string $avatar;

	/**
	 * @ORM\OneToMany(targetEntity=Trick::class, mappedBy="user")
	 */
	private Collection $tricks;

	/**
	 * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user")
	 */
	private Collection $comments;

	/**
	 * @ORM\Column(type="json", nullable=true)
	 */
	private $roles = [];

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $token;

	public function __construct()
	{
		$this->create_at = new DateTime( 'now' );
		$this->tricks    = new ArrayCollection();
		$this->comments  = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getPseudo(): ?string
	{
		return $this->pseudo;
	}

	public function setPseudo( string $pseudo ): self
	{
		$this->pseudo = $pseudo;

		return $this;
	}

	public function getFirstname(): ?string
	{
		return $this->firstname;
	}

	public function setFirstname( ?string $firstname ): self
	{
		$this->firstname = $firstname;

		return $this;
	}

	public function getLastname(): ?string
	{
		return $this->lastname;
	}

	public function setLastname( ?string $lastname ): self
	{
		$this->lastname = $lastname;

		return $this;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail( string $email ): self
	{
		$this->email = $email;

		return $this;
	}

	public function getPassword(): ?string
	{
		return $this->password;
	}

	public function setPassword( string $password ): self
	{
		$this->password = $password;

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

	public function getAvatar(): ?string
	{
		return $this->avatar;
	}

	public function setAvatar( ?string $avatar ): self
	{
		$this->avatar = $avatar;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getConfirmPassword(): ?string
	{
		return $this->confirm_password;
	}

	/**
	 * @param string|null $confirm_password
	 */
	public function setConfirmPassword( ?string $confirm_password ): void
	{
		$this->confirm_password = $confirm_password;
	}

	public function getSalt()
	{
		return null;
	}

	public function getUsername()
	{
		return $this->getEmail();
	}

	public function eraseCredentials()
	{
	}

	public function getRoles()
	{
		return [ 'ROLE_ADMIN' ];
	}

	public function serialize()
	{
		return serialize( [
			$this->id,
			$this->pseudo,
			$this->firstname,
			$this->lastname,
			$this->email,
			$this->password,
			$this->avatar
		] );
	}

	public function unserialize( $serialized )
	{
		list( $this->id, $this->pseudo, $this->firstname, $this->lastname, $this->email, $this->password, $this->avatar ) = unserialize( $serialized, [ 'allowed_classes' => false ] );
	}

	public function setRoles( ?array $roles ): self
	{
		$this->roles = $roles;

		return $this;
	}

	public function getToken(): ?string
	{
		return $this->token;
	}

	public function setToken( ?string $token ): self
	{
		$this->token = $token;

		return $this;
	}
}
