<?php

namespace App\DataFixtures;

use App\Entity\Blog\DirectMessage;
use App\Entity\User;
use App\Repository\Blog\MessageRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class DirectMessageFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private MessageRepository $messageRepository;
    private ?User $userReference;

    public function __construct(
        MessageRepository $messageRepository,
    ) {
        $this->messageRepository = $messageRepository;
        /* @var User */
        if ($this->get)
        $this->userReference = $this->getReference(UserFixtures::ADMIN_USER_REFERENCE);
    }

    public function load(ObjectManager $manager): void
    {
        $messages = $this->messageRepository->findAll();

        for ($i = 0; $i < count($messages); ++$i) {
            $directMessage = new DirectMessage();
            $directMessage->setReceiver($this->userReference);
            foreach ($messages as $message) {
                $directMessage->addMessage($message);
            }
            $directMessage->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($directMessage);
        }

        $manager->flush();
    }

    /**
     * @return array<string>
     */
    public static function getGroups(): array
    {
        return ['blog'];
    }

    /**
     * @psalm-return array<class-string<Fixture>>
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            MessageFixtures::class,
        ];
    }
}
