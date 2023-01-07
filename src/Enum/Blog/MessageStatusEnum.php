<?php

namespace App\Enum\Blog;

enum MessageStatusEnum: string
{
    case Draft = 'draft';
    case Sent = 'sent';
    case Read = 'read';
    case IsSpam = 'is_spam';
}
