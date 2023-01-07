<?php

namespace App\Entity\Blog;

use App\Entity\Blog\Histories\UserDirectMessageHistory;
use App\Entity\User;
use App\Repository\Blog\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ORM\Table(name: '`blog__message`')]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 170)]
    private ?string $subject = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?User $sender = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message_body = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $creation_date = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?self $parent_message = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\ManyToOne(inversedBy: 'message')]
    private ?DirectMessage $directMessage = null;

    #[ORM\ManyToOne(inversedBy: 'message')]
    private ?UserDirectMessageHistory $userDirectMessageHistory = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getMessageBody(): ?string
    {
        return $this->message_body;
    }

    public function setMessageBody(string $message_body): self
    {
        $this->message_body = $message_body;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeImmutable
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeImmutable $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getParentMessage(): ?self
    {
        return $this->parent_message;
    }

    public function setParentMessage(?self $parent_message): self
    {
        $this->parent_message = $parent_message;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDirectMessage(): ?DirectMessage
    {
        return $this->directMessage;
    }

    public function setDirectMessage(?DirectMessage $directMessage): self
    {
        $this->directMessage = $directMessage;

        return $this;
    }

    public function getUserDirectMessageHistory(): ?UserDirectMessageHistory
    {
        return $this->userDirectMessageHistory;
    }

    public function setUserDirectMessageHistory(?UserDirectMessageHistory $userDirectMessageHistory): self
    {
        $this->userDirectMessageHistory = $userDirectMessageHistory;

        return $this;
    }
}
