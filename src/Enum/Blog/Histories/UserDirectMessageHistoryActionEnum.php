<?php

namespace App\Enum\Blog\Histories;

enum UserDirectMessageHistoryActionEnum: string
{
    case Created = 'created';
    case Sent = 'sent';
}
