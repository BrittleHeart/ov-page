<?php

namespace App\DataFixtures;

use App\Entity\Blog\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * @var array<string>
     */
    private static array $sampleCategories = [
        'życie codziennie',
        'praca',
        'programowanie',
        'kulinarnie',
        'nauka',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::$sampleCategories as $sampleCategory) {
            $category = new Category();
            $category->setName($sampleCategory);
            $category->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($category);
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
