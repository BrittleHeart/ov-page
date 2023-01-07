<?php

namespace App\DataFixtures;

use App\Entity\RSS\Result;
use App\Traits\WithFaker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * @psalm-suppress MixedArgument
 */
class ResultFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    use WithFaker;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $result = new Result();

            $result->setTitle($this->getFaker()->sentence(3));
            $result->setDescription($this->getFaker()->sentence(10));
            $result->setLink($this->getFaker()->url());
            $result->setGuid($this->getFaker()->uuid());
            $result->setPubDate(new \DateTimeImmutable());
            $manager->persist($result);
        }

        // @phpstan-ignore-next-line
        $result->setRssGroup($this->getReference(GroupFixtures::GROUP_REFERENCE));

        // @phpstan-ignore-next-line
        $result->setAuthor($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $manager->flush();
    }

    /**
     * @return array<string>
     */
    public static function getGroups(): array
    {
        return ['rss'];
    }

    /**
     * @psalm-return array<class-string<Fixture>>
     */
    public function getDependencies(): array
    {
        return [
            GroupFixtures::class,
            UserFixtures::class,
        ];
    }
}
