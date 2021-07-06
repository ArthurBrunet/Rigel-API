<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordRequirements;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(
     *     message="Merci de renseigner votre email.",
     *     groups={"Register"}
     *     )
     *
     * @Assert\Email(
     *     message="Veuillez renseigner un mail valide.",
     *     groups={"Register"}
     *     )
     *
     *
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=true)
     * @PasswordRequirements(
     *     minLength=8,
     *     requireNumbers=true,
     *     requireLetters=true,
     *     requireCaseDiff=true,
     *     requireSpecialCharacter=true,
     *     groups={"Register"}
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $drink;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEnable;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVisible;

    /**
     * @ORM\OneToOne(targetEntity=IdeaBox::class, mappedBy="idUser", cascade={"persist", "remove"})
     */
    private $ideaBox;

    /**
     * @ORM\OneToMany(targetEntity=IdeaBox::class, mappedBy="idUser", orphanRemoval=true)
     */
    private $ideaBoxes;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="user")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity=EmergencyAperitif::class, mappedBy="User")
     */
    private $emergencyAperitifs;

    /**
     * @ORM\OneToMany(targetEntity=AperitifResponse::class, mappedBy="User")
     */
    private $aperitifResponses;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(
     *     message="Merci de renseigner votre numéro de téléphone.",
     *     groups={"Register"}
     *     )
     *
     * @Assert\Length(
     *     min="10",
     *     minMessage="Veuillez renseigner un numéro de téléphone correct.",
     *     groups={"Register"}
     *     )
     * @Assert\Length(
     *     max="10",
     *     maxMessage="Veuillez renseigner un numéro de téléphone correct.",
     *     groups={"Register"}
     *     )
     */
    private $phoneNumber;
  
     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $competence;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="created_by")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity=Canal::class, mappedBy="user")
     */
    private $canals;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->emergencyAperitifs = new ArrayCollection();
        $this->aperitifResponses = new ArrayCollection();
        $this->ideaBoxes = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->canals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersist()
    {
        if (empty($this->getRoles())) {
            $this->setRoles(['ROLE_USER']);
        }
        if (empty($this->getToken())) {
            $this->setToken(rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '='));
        }
        if (empty($this->getIsEnable())) {
            $this->setIsEnable(true);
        }
        if (empty($this->getIsVisible())) {
            $this->setIsVisible(true);
        }
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDrink(): ?string
    {
        return $this->drink;
    }

    public function setDrink(?string $drink): self
    {
        $this->drink = $drink;

        return $this;
    }

    public function getIsEnable(): ?bool
    {
        return $this->isEnable;
    }

    public function setIsEnable(bool $isEnable): self
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    public function getIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * @return Collection|IdeaBox[]
     */
    public function getIdeaBoxes(): Collection
    {
        return $this->ideaBoxes;
    }

    public function addIdeaBox(IdeaBox $ideaBox): self
    {
        if (!$this->ideaBoxes->contains($ideaBox)) {
            $this->ideaBoxes[] = $ideaBox;
            $ideaBox->setIdUser($this);
        }
    }

    public function removeIdeaBox(IdeaBox $ideaBox): self
    {
        if ($this->ideaBoxes->removeElement($ideaBox)) {
            // set the owning side to null (unless already changed)
            if ($ideaBox->getIdUser() === $this) {
                $ideaBox->setIdUser(null);
            }
        }
        return $this;
    }

     /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EmergencyAperitif[]
     */
    public function getEmergencyAperitifs(): Collection
    {
        return $this->emergencyAperitifs;
    }

    public function addEmergencyAperitif(EmergencyAperitif $emergencyAperitif): self
    {
        if (!$this->emergencyAperitifs->contains($emergencyAperitif)) {
            $this->emergencyAperitifs[] = $emergencyAperitif;
            $emergencyAperitif->setUser($this);
        }

        return $this;
    }

    public function removeEmergencyAperitif(EmergencyAperitif $emergencyAperitif): self
    {
        if ($this->emergencyAperitifs->removeElement($emergencyAperitif)) {
            // set the owning side to null (unless already changed)
            if ($emergencyAperitif->getUser() === $this) {
                $emergencyAperitif->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AperitifResponse[]
     */
    public function getAperitifResponses(): Collection
    {
        return $this->aperitifResponses;
    }

    public function addAperitifResponse(AperitifResponse $aperitifResponse): self
    {
        if (!$this->aperitifResponses->contains($aperitifResponse)) {
            $this->aperitifResponses[] = $aperitifResponse;
            $aperitifResponse->setUser($this);
        }

        return $this;
    }

    public function removeAperitifResponse(AperitifResponse $aperitifResponse): self
    {
        if ($this->aperitifResponses->removeElement($aperitifResponse)) {
            // set the owning side to null (unless already changed)
            if ($aperitifResponse->getUser() === $this) {
                $aperitifResponse->setUser(null);
            }
        }

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }
  
    public function getCompetence(): ?string
    {
        return $this->competence;
    }

    public function setCompetence(?string $competence): self
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setCreatedBy($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getCreatedBy() === $this) {
                $message->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Canal[]
     */
    public function getCanals(): Collection
    {
        return $this->canals;
    }

    public function addCanal(Canal $canal): self
    {
        if (!$this->canals->contains($canal)) {
            $this->canals[] = $canal;
            $canal->addUser($this);
        }

        return $this;
    }

    public function removeCanal(Canal $canal): self
    {
        if ($this->canals->removeElement($canal)) {
            $canal->removeUser($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getUsername();
    }
}
