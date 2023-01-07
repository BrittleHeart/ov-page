<?php

namespace App\DataFixtures;

use App\Entity\Blog\Comment;
use App\Enum\Blog\CommentStatusEnum;
use App\Traits\WithFaker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    use WithFaker;

    /**
     * @var array<CommentStatusEnum>
     */
    private static array $allowedStatues = [
        CommentStatusEnum::Approved,
        CommentStatusEnum::Submitted,
        CommentStatusEnum::Rejected,
    ];

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $comment = new Comment();

            /*
             * @phpstan-ignore-next-line
             */
            $comment->setAuthor($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
            $comment->setTitle($this->getFaker()->text(10));
            /* @phpstan-ignore-next-line */
            $comment->setStatus($this->getFaker()->randomElement(self::$allowedStatues)->value);
            $comment->setContent($this->getFaker()->sentence(5, true));
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setUpdatedAt(new \DateTimeImmutable());

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['blog'];
    }
}
