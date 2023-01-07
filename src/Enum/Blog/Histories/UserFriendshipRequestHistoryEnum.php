<?php

namespace App\Enum\Blog\Histories;

enum UserFriendshipRequestHistoryActionEnum: string
{
    case Accepted = 'accepted';
    case Declined = 'declined';
    case Sent = 'sent';
}
