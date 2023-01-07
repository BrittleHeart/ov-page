<?php

namespace App\DataFixtures;

use App\Entity\Blog\Message;
use App\Enum\Blog\MessageStatusEnum;
use App\Traits\WithFaker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MessageFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    use WithFaker;

    /** @var array<MessageStatusEnum> */
    private static array $allowedStatues = [
        MessageStatusEnum::Draft,
        MessageStatusEnum::Sent,
        MessageStatusEnum::Read,
        MessageStatusEnum::IsSpam,
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = $this->getFaker();

        for ($i = 0; $i < 10; ++$i) {
            $message = new Message();
            $message->setSubject($faker->realText(20));
            /* @phpstan-ignore-next-line */
            $message->setSender($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
            $message->setMessageBody($faker->realText(1000));
            /* @phpstan-ignore-next-line */
            $message->setStatus($faker->randomElement(self::$allowedStatues)->value);
            $message->setCreationDate(new \DateTimeImmutable());

            $manager->persist($message);
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
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
