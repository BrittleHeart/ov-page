<?php

namespace App\Enum\Blog;

enum FileMimeTypeEnum: string
{
    case ImagePng = 'image/png';
    case ImageJpeg = 'image/jpeg';
    case ImageGif = 'image/gif';
    case ImageWebp = 'image/webp';
    case ImageSvg = 'image/svg+xml';
    case VideoMp4 = 'video/mp4';
    case VideoWebm = 'video/webm';
    case VideoOgg = 'video/ogg';
    case AudioMpeg = 'audio/mpeg';
    case AudioOgg = 'audio/ogg';
    case DocumentPdf = 'application/pdf';
    case DocumentMsWord = 'application/msword';
    case DocumentMsExcel = 'application/vnd.ms-excel';
    case DocumentMsPowerpoint = 'application/vnd.ms-powerpoint';
    case FileText = 'text/plain';
    case FileZip = 'application/zip';
    case FileRar = 'application/x-rar-compressed';

    /**
     * @return array<self>
     */
    public static function values(): array
    {
        return [
            self::ImagePng,
            self::ImageJpeg,
            self::ImageGif,
            self::ImageWebp,
            self::ImageSvg,
            self::VideoMp4,
            self::VideoWebm,
            self::VideoOgg,
            self::AudioMpeg,
            self::AudioOgg,
            self::DocumentPdf,
            self::DocumentMsWord,
            self::DocumentMsExcel,
            self::DocumentMsPowerpoint,
            self::FileText,
            self::FileZip,
            self::FileRar,
        ];
    }

    public static function isImage(string $value): bool
    {
        return in_array($value, [
            self::ImagePng,
            self::ImageJpeg,
            self::ImageGif,
            self::ImageWebp,
            self::ImageSvg,
        ]);
    }

    public static function isVideo(string $value): bool
    {
        return in_array($value, [
            self::VideoMp4,
            self::VideoWebm,
            self::VideoOgg,
        ]);
    }

    public static function isAudio(string $value): bool
    {
        return in_array($value, [
            self::AudioMpeg,
            self::AudioOgg,
        ]);
    }

    public static function isDocument(string $value): bool
    {
        return in_array($value, [
            self::DocumentPdf,
            self::DocumentMsWord,
            self::DocumentMsExcel,
            self::DocumentMsPowerpoint,
        ]);
    }

    public static function isFile(string $value): bool
    {
        return in_array($value, [
            self::FileText,
            self::FileZip,
            self::FileRar,
        ]);
    }
}
