<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class UserFixtures extends Fixture implements FixtureGroupInterface
{
    private UserPasswordHasherInterface $passwordHasher;
    public const ADMIN_USER_REFERENCE = 'user-admin';

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'admin');

        $user->setEmail('admin@localhost');
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $manager->persist($user);

        $manager->flush();

        $this->addReference(self::ADMIN_USER_REFERENCE, $user);
    }

    /**
     * @return array<string>
     */
    public static function getGroups(): array
    {
        return ['authorization', 'rss', 'blog'];
    }
}
