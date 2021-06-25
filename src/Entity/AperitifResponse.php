<?php

namespace App\Entity;

use App\Repository\AperitifResponseRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=AperitifResponseRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class AperitifResponse
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     */
    private $response = [];

    /**
     * @ORM\ManyToOne(targetEntity=EmergencyAperitif::class, inversedBy="AperitifResponse")
     */
    private $emergencyAperitif;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="aperitifResponses")
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
