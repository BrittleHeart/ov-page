<?php

namespace App\DataFixtures;

use App\Entity\Blog\Attachment;
use App\Enum\Blog\AttachmentTypeEnum;
use App\Traits\WithFaker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class AttachmentFixtures extends Fixture implements FixtureGroupInterface
{
    use WithFaker;

    /**
     * @var array<AttachmentTypeEnum>
     */
    protected static array $allowedTypes;

    public function __construct()
    {
        self::$allowedTypes = AttachmentTypeEnum::values();
    }

    public function load(ObjectManager $manager): void
    {
        $faker = $this->getFaker();

        foreach (self::$allowedTypes as $type) {
            $attachment = new Attachment();
            $attachment->setType($type->value);

            switch ($type) {
                case AttachmentTypeEnum::Image:
                    $attachmentName = $faker->text(5).'.jpg';
                    $attachment->setName($attachmentName);
                    break;
                case AttachmentTypeEnum::File:
                    $attachmentName = $faker->text(5).'.pdf';
                    $attachment->setName($attachmentName);
                    break;
                case AttachmentTypeEnum::Video:
                    $attachmentName = $faker->text(5).'.mp4';
                    $attachment->setName($attachmentName);
                    break;
                case AttachmentTypeEnum::Audio:
                    $attachmentName = $faker->text(5).'.mp3';
                    $attachment->setName($attachmentName);
                    break;
            }

            $attachment->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($attachment);
        }

        $manager->flush();
    }

    /**
     * @return array<string>
     */
    public static function getGroups(): array
    {
        return ['file', 'blog'];
    }
}
