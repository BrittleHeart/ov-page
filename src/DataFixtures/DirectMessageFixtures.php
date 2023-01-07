<?php

namespace App\DataFixtures;

use App\Entity\Blog\DirectMessage;
use App\Repository\Blog\MessageRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class DirectMessageFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    private MessageRepository $messageRepository;

    public function __construct(
        MessageRepository $messageRepository,
    ) {
        $this->messageRepository = $messageRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $messages = $this->messageRepository->findAll();

        for ($i = 0; $i < count($messages); ++$i) {
            $directMessage = new DirectMessage();
            /* @phpstan-ignore-next-line */
            $directMessage->setReceiver($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
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
