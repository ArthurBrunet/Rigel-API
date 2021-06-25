<?php

namespace App\Entity;

use App\Repository\EmergencyAperitifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=EmergencyAperitifRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class EmergencyAperitif
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $meetingPoint;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emergency;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reason;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="emergencyAperitifs")
     */
    private $User;

    /**
     * @ORM\OneToMany(targetEntity=AperitifResponse::class, mappedBy="emergencyAperitif")
     */
    private $AperitifResponse;

    public function __construct()
    {
        $this->AperitifResponse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeetingPoint(): ?string
    {
        return $this->meetingPoint;
    }

    public function setMeetingPoint(string $meetingPoint): self
    {
        $this->meetingPoint = $meetingPoint;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEmergency(): ?string
    {
        return $this->emergency;
    }

    public function setEmergency(string $emergency): self
    {
        $this->emergency = $emergency;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

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

    /**
     * @return Collection|AperitifResponse[]
     */
    public function getAperitifResponse(): Collection
    {
        return $this->AperitifResponse;
    }

    public function addAperitifResponse(AperitifResponse $aperitifResponse): self
    {
        if (!$this->AperitifResponse->contains($aperitifResponse)) {
            $this->AperitifResponse[] = $aperitifResponse;
            $aperitifResponse->setEmergencyAperitif($this);
        }

        return $this;
    }

    public function removeAperitifResponse(AperitifResponse $aperitifResponse): self
    {
        if ($this->AperitifResponse->removeElement($aperitifResponse)) {
            // set the owning side to null (unless already changed)
            if ($aperitifResponse->getEmergencyAperitif() === $this) {
                $aperitifResponse->setEmergencyAperitif(null);
            }
        }

        return $this;
    }
}
