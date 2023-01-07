<?php

namespace App\Entity\Blog\Histories;

use App\Entity\Blog\Message;
use App\Entity\User;
use App\Repository\Blog\Histories\UserDirectMessageHistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserDirectMessageHistoryRepository::class)]
#[ORM\Table(name: '`blog_histories__user_direct_message`')]
class UserDirectMessageHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userDirectMessageHistories')]
    private ?User $receiver = null;

    /**
     * @var ArrayCollection<int, Message>
     */
    #[ORM\OneToMany(mappedBy: 'userDirectMessageHistory', targetEntity: Message::class)]
    private Collection $message;

    #[ORM\Column(length: 20)]
    private ?string $action = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $created_at = null;

    public function __construct()
    {
        $this->message = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessage(): Collection
    {
        return $this->message;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->message->contains($message)) {
            $this->message->add($message);
            $message->setUserDirectMessageHistory($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->message->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUserDirectMessageHistory() === $this) {
                $message->setUserDirectMessageHistory(null);
            }
        }

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
