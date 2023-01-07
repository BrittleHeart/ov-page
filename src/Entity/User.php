<?php

namespace App\Entity;

use App\Entity\Blog\Comment;
use App\Entity\Blog\DirectMessage;
use App\Entity\Blog\Friendship;
use App\Entity\Blog\Histories\PostHistoryAction;
use App\Entity\Blog\Histories\UserDirectMessageHistory;
use App\Entity\Blog\Histories\UserFriendshipRequestHistory;
use App\Entity\Blog\Message;
use App\Entity\Blog\Post;
use App\Entity\RSS\Result;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /**
     * @var array<int, string>
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var ArrayCollection<int, Result>
     */
    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Result::class)]
    private Collection $results;

    /**
     * @var ArrayCollection<int, Post>
     */
    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Post::class)]
    private Collection $posts;

    /**
     * @var ArrayCollection<int, Comment>
     */
    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Comment::class)]
    private Collection $comments;

    /**
     * @var ArrayCollection<int, Friendship>
     */
    #[ORM\OneToMany(mappedBy: 'friend', targetEntity: Friendship::class)]
    private Collection $friendships;

    /**
     * @var ArrayCollection<int, Message>
     */
    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: Message::class)]
    private Collection $messages;

    /**
     * @var ArrayCollection<int, DirectMessage>
     */
    #[ORM\OneToMany(mappedBy: 'receiver', targetEntity: DirectMessage::class)]
    private Collection $directMessages;

    /**
     * @var ArrayCollection<int, UserDirectMessageHistory>
     */
    #[ORM\OneToMany(mappedBy: 'receiver', targetEntity: UserDirectMessageHistory::class)]
    private Collection $userDirectMessageHistories;

    /**
     * @var ArrayCollection<int, UserFriendshipRequestHistory>
     */
    #[ORM\OneToMany(mappedBy: 'friend', targetEntity: UserFriendshipRequestHistory::class)]
    private Collection $userFriendshipRequestHistories;

    /**
     * @var ArrayCollection<int, PostHistoryAction>
     */
    #[ORM\OneToMany(mappedBy: 'author', targetEntity: PostHistoryAction::class)]
    private Collection $postHistoryActions;

    public function __construct()
    {
        $this->results = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->friendships = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->directMessages = new ArrayCollection();
        $this->userDirectMessageHistories = new ArrayCollection();
        $this->userFriendshipRequestHistories = new ArrayCollection();
        $this->postHistoryActions = new ArrayCollection();
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    /**
     * @param array<int, string> $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
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
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Result>
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(Result $result): self
    {
        if (!$this->results->contains($result)) {
            $this->results->add($result);
            $result->setAuthor($this);
        }

        return $this;
    }

    public function removeResult(Result $result): self
    {
        if ($this->results->removeElement($result)) {
            // set the owning side to null (unless already changed)
            if ($result->getAuthor() === $this) {
                $result->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setAuthor($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendships(): Collection
    {
        return $this->friendships;
    }

    public function addFriendship(Friendship $friendship): self
    {
        if (!$this->friendships->contains($friendship)) {
            $this->friendships->add($friendship);
            $friendship->setFriend($this);
        }

        return $this;
    }

    public function removeFriendship(Friendship $friendship): self
    {
        if ($this->friendships->removeElement($friendship)) {
            // set the owning side to null (unless already changed)
            if ($friendship->getFriend() === $this) {
                $friendship->setFriend(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setSender($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DirectMessage>
     */
    public function getDirectMessages(): Collection
    {
        return $this->directMessages;
    }

    public function addDirectMessage(DirectMessage $directMessage): self
    {
        if (!$this->directMessages->contains($directMessage)) {
            $this->directMessages->add($directMessage);
            $directMessage->setReceiver($this);
        }

        return $this;
    }

    public function removeDirectMessage(DirectMessage $directMessage): self
    {
        if ($this->directMessages->removeElement($directMessage)) {
            // set the owning side to null (unless already changed)
            if ($directMessage->getReceiver() === $this) {
                $directMessage->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserDirectMessageHistory>
     */
    public function getUserDirectMessageHistories(): Collection
    {
        return $this->userDirectMessageHistories;
    }

    public function addUserDirectMessageHistory(UserDirectMessageHistory $userDirectMessageHistory): self
    {
        if (!$this->userDirectMessageHistories->contains($userDirectMessageHistory)) {
            $this->userDirectMessageHistories->add($userDirectMessageHistory);
            $userDirectMessageHistory->setReceiver($this);
        }

        return $this;
    }

    public function removeUserDirectMessageHistory(UserDirectMessageHistory $userDirectMessageHistory): self
    {
        if ($this->userDirectMessageHistories->removeElement($userDirectMessageHistory)) {
            // set the owning side to null (unless already changed)
            if ($userDirectMessageHistory->getReceiver() === $this) {
                $userDirectMessageHistory->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserFriendshipRequestHistory>
     */
    public function getUserFriendshipRequestHistories(): Collection
    {
        return $this->userFriendshipRequestHistories;
    }

    public function addUserFriendshipRequestHistory(UserFriendshipRequestHistory $userFriendshipRequestHistory): self
    {
        if (!$this->userFriendshipRequestHistories->contains($userFriendshipRequestHistory)) {
            $this->userFriendshipRequestHistories->add($userFriendshipRequestHistory);
            $userFriendshipRequestHistory->setFriend($this);
        }

        return $this;
    }

    public function removeUserFriendshipRequestHistory(UserFriendshipRequestHistory $userFriendshipRequestHistory): self
    {
        if ($this->userFriendshipRequestHistories->removeElement($userFriendshipRequestHistory)) {
            // set the owning side to null (unless already changed)
            if ($userFriendshipRequestHistory->getFriend() === $this) {
                $userFriendshipRequestHistory->setFriend(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PostHistoryAction>
     */
    public function getPostHistoryActions(): Collection
    {
        return $this->postHistoryActions;
    }

    public function addPostHistoryAction(PostHistoryAction $postHistoryAction): self
    {
        if (!$this->postHistoryActions->contains($postHistoryAction)) {
            $this->postHistoryActions->add($postHistoryAction);
            $postHistoryAction->setAuthor($this);
        }

        return $this;
    }

    public function removePostHistoryAction(PostHistoryAction $postHistoryAction): self
    {
        if ($this->postHistoryActions->removeElement($postHistoryAction)) {
            // set the owning side to null (unless already changed)
            if ($postHistoryAction->getAuthor() === $this) {
                $postHistoryAction->setAuthor(null);
            }
        }

        return $this;
    }
}
