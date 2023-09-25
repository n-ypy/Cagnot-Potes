<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
class Participant
{

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Assert\Uuid]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;


    #[ORM\ManyToOne(inversedBy: 'participants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campaign $campaign = null;

    #[ORM\OneToOne(mappedBy: 'participant', cascade: ['persist', 'remove'])]
    private ?Payment $payment = null;

    #[ORM\Column]
    private ?bool $hideName = null;

    #[ORM\Column]
    private ?bool $hideAmount = null;

    public function __construct()
    {
        $this->setCreatedAt();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at = null): static
    {
        $this->created_at = $created_at ?? new \DateTimeImmutable();

        return $this;
    }

    public function getCampaign(): ?campaign
    {
        return $this->campaign;
    }

    public function setCampaign(?campaign $campaign): static
    {
        $this->campaign = $campaign;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(Payment $payment): static
    {
        // set the owning side of the relation if necessary
        if ($payment->getParticipant() !== $this) {
            $payment->setParticipant($this);
        }

        $this->payment = $payment;

        return $this;
    }

    public function isHideName(): ?bool
    {
        return $this->hideName;
    }

    public function setHideName(bool $hideName): static
    {
        $this->hideName = $hideName;

        return $this;
    }

    public function isHideAmount(): ?bool
    {
        return $this->hideAmount;
    }

    public function setHideAmount(bool $hideAmount): static
    {
        $this->hideAmount = $hideAmount;

        return $this;
    }
}
