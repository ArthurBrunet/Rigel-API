<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @OA\Schema()
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @OA\Property(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @OA\Property(type="string", description="Post title max length 50")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @OA\Property(type="string", description="Post banner", nullable=true)
     */
    private $banner;

    /**
     * @ORM\Column(type="string", length=255)
     * @OA\Property(type="string", description="Post content max lenght 255")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @OA\Property(type="string", format="date-time", description="Post date publication")
     */
    private $datePost;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     * @OA\Property(type="object", description="Post user-infos")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=SonataMediaMedia::class, cascade={"persist", "remove"})
     *  @OA\Property(type="object", description="Post medias")
     */
    private $media;

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

    public function getBanner(): ?string
    {
        return $this->banner;
    }

    public function setBanner(?string $banner): self
    {
        $this->banner = $banner;

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

    public function getDatePost(): ?\DateTimeInterface
    {
        return $this->datePost;
    }

    public function setDatePost(\DateTimeInterface $datePost): self
    {
        $this->datePost = $datePost;

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

    public function getMedia(): ?SonataMediaMedia
    {
        return $this->media;
    }

    public function setMedia(?SonataMediaMedia $media): self
    {
        $this->media = $media;

        return $this;
    }
}
