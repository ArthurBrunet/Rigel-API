<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 * @OA\Schema()
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @OA\Property(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @OA\Property(type="string", description="Company name max length 255")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @OA\Property(type="string", description="Company description  max length 255", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=TypeCompany::class, inversedBy="companies")
     * @OA\Property(type="string", description="Company description  max length 255", nullable=true)
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?TypeCompany
    {
        return $this->type;
    }

    public function setType(?TypeCompany $type): self
    {
        $this->type = $type;

        return $this;
    }
}
