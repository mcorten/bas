<?php

declare(strict_types=1);

namespace App\Entity;

use App\Shared\Encryptor\Adapter\MessageRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[UniqueEntity('lookup')]
#[HasLifecycleCallbacks]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(length: 255)]
    private ?string $recipient = null;

    // this exists of: one_time or date
    // might be better to migrate it to an enum
    #[ORM\Column(length: 16)]
    private ?string $expiry_mode = null;

    #[ORM\Column(type: UuidType::NAME)]
    private ?Uuid $lookup = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $expiry_date = null;

    #[ORM\Column]
    private ?DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): static
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getLookup(): ?Uuid
    {
        return $this->lookup;
    }

    public function setLookup(Uuid $lookup): static
    {
        $this->lookup = $lookup;
        return $this;
    }

    public function getExpiryMode(): ?string
    {
        return $this->expiry_mode;
    }

    public function setExpiryMode(string $expiry_mode): static
    {
        $this->expiry_mode = $expiry_mode;

        return $this;
    }

    public function getExpiryDate(): ?\DateTimeImmutable
    {
        return $this->expiry_date;
    }

    public function setExpiryDate(?DateTimeImmutable $expiry_date): static
    {
        $this->expiry_date = $expiry_date;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->created_at = new \DateTimeImmutable();
        $this->lookup =  Uuid::v7();
    }
}
