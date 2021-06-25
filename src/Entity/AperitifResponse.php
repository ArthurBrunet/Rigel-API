<?php

namespace App\Entity;

use App\Repository\AperitifResponseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AperitifResponseRepository::class)
 * @OA\Schema()
 */
class AperitifResponse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @OA\Property(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     * @OA\Property(type="object", description="Aperitif Response json format")
     */
    private $response = [];

    /**
     * @ORM\ManyToOne(targetEntity=EmergencyAperitif::class, inversedBy="AperitifResponse")
     * @OA\Property(type="object", description="Aperitif Response emergency")
     */
    private $emergencyAperitif;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="aperitifResponses")
     * @OA\Property(type="object", description="Aperitif Response users")
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponse(): ?array
    {
        return $this->response;
    }

    public function setResponse(array $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getEmergencyAperitif(): ?EmergencyAperitif
    {
        return $this->emergencyAperitif;
    }

    public function setEmergencyAperitif(?EmergencyAperitif $emergencyAperitif): self
    {
        $this->emergencyAperitif = $emergencyAperitif;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
