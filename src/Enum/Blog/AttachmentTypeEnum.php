<?php

namespace App\Enum\Blog;

enum AttachmentTypeEnum: string
{
    case Image = 'image';
    case Video = 'video';
    case Audio = 'audio';
    case File = 'file';

    /**
     * @psalm-return array<int, AttachmentTypeEnum>
     */
    public static function values(): array
    {
        return [
            self::Image,
            self::Video,
            self::Audio,
            self::File,
        ];
    }
}
