<?php

namespace App\DataFixtures;

use App\Entity\RSS\Group;
use App\Enum\RSSGroupLanguageEnum;
use App\Traits\WithFaker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class GroupFixtures extends Fixture implements FixtureGroupInterface
{
    use WithFaker;

    public const GROUP_REFERENCE = 'group';

    public function load(ObjectManager $manager): void
    {
        $availableLanguages = [
            RSSGroupLanguageEnum::pl_PL,
            RSSGroupLanguageEnum::en_US,
        ];

        foreach ($availableLanguages as $language) {
            $group = new Group();
            $group->setUrl($this->getFaker()->url());
            $group->setTitle($this->getFaker()->sentence(3));
            $group->setDescription($this->getFaker()->sentence(10));
            $group->setLanguage($language->value);

            $manager->persist($group);
        }

        $this->addReference(self::GROUP_REFERENCE, $group);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['rss'];
    }
}
