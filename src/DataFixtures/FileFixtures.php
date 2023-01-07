<?php

namespace App\DataFixtures;

use App\Entity\Blog\File;
use App\Enum\Blog\FileMimeTypeEnum;
use App\Traits\WithFaker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class FileFixtures extends Fixture implements FixtureGroupInterface
{
    use WithFaker;

    protected const ORIGINAL_FILENAME = 'original__';

    /**
     * @var array<FileMimeTypeEnum>
     */
    protected static array $allowedTypes = [
        FileMimeTypeEnum::ImagePng,
        FileMimeTypeEnum::ImageJpeg,
        FileMimeTypeEnum::ImageGif,
        FileMimeTypeEnum::ImageWebp,
        FileMimeTypeEnum::ImageSvg,
        FileMimeTypeEnum::VideoMp4,
        FileMimeTypeEnum::VideoWebm,
        FileMimeTypeEnum::VideoOgg,
        FileMimeTypeEnum::AudioMpeg,
        FileMimeTypeEnum::AudioOgg,
        FileMimeTypeEnum::DocumentPdf,
        FileMimeTypeEnum::DocumentMsWord,
        FileMimeTypeEnum::DocumentMsExcel,
        FileMimeTypeEnum::DocumentMsPowerpoint,
        FileMimeTypeEnum::FileText,
        FileMimeTypeEnum::FileZip,
        FileMimeTypeEnum::FileRar,
    ];

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $file = new File();
            $originalFilename = 'original__'.$this->getFaker()->text(5).'.jpg';

            $file->setOriginalName($originalFilename);
            /* @phpstan-ignore-next-line */
            $file->setMimetype($this->getFaker()->randomElement(self::$allowedTypes)->value);

            $fileExtension = null;
            switch ($file->getMimetype()) {
                case FileMimeTypeEnum::ImagePng->value:
                    $fileExtension = 'png';
                    break;
                case FileMimeTypeEnum::ImageJpeg->value:
                    $fileExtension = 'jpg';
                    break;
                case FileMimeTypeEnum::ImageGif->value:
                    $fileExtension = 'gif';
                    break;
                case FileMimeTypeEnum::ImageWebp->value:
                    $fileExtension = 'webp';
                    break;
                case FileMimeTypeEnum::ImageSvg->value:
                    $fileExtension = 'svg';
                    break;
                case FileMimeTypeEnum::VideoMp4->value:
                    $fileExtension = 'mp4';
                    break;
                case FileMimeTypeEnum::VideoWebm->value:
                    $fileExtension = 'webm';
                    break;
                case FileMimeTypeEnum::VideoOgg->value:
                    $fileExtension = 'ogg';
                    break;
                case FileMimeTypeEnum::AudioMpeg->value:
                    $fileExtension = 'mp3';
                    break;
                case FileMimeTypeEnum::AudioOgg->value:
                    $fileExtension = 'ogg';
                    break;
                case FileMimeTypeEnum::DocumentPdf->value:
                    $fileExtension = 'pdf';
                    break;
                case FileMimeTypeEnum::DocumentMsWord->value:
                    $fileExtension = 'doc';
                    break;
                case FileMimeTypeEnum::DocumentMsExcel->value:
                    $fileExtension = 'xls';
                    break;
                case FileMimeTypeEnum::DocumentMsPowerpoint->value:
                    $fileExtension = 'ppt';
                    break;
                case FileMimeTypeEnum::FileText->value:
                    $fileExtension = 'txt';
                    break;
                case FileMimeTypeEnum::FileZip->value:
                    $fileExtension = 'zip';
                    break;
                case FileMimeTypeEnum::FileRar->value:
                    $fileExtension = 'rar';
                    break;
            }

            $file->setExtension($fileExtension ?? '');
            $file->setFilename($this->getFaker()->text(5).".{$fileExtension}");
            $file->setChecksum(hash('sha256', $this->getFaker()->text(5)));
            $file->setSize((string) $this->getFaker()->numberBetween(100, 100000));
            $file->setRelativePath("/uploads/{$file->getFilename()}");
            $file->setAbsolutePath("/var/www/html/uploads/{$file->getFilename()}");
            $file->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($file);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['files', 'blog'];
    }
}
