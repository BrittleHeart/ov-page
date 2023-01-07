<?php

namespace App\DataFixtures;

use App\Entity\Blog\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * @var array<string>
     */
    public static array $sampleTags = [
        'php',
        'daily',
        'spostrzeżenia',
        'programowanie',
        'javascript',
        'frontend',
        'backend',
        'blog',
        'obiad',
        'śniadanie',
        'przekąski',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::$sampleTags as $sampleTag) {
            $tag = new Tag();

            $tag->setName($sampleTag);
            $tag->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($tag);
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
}
