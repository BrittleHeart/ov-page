<?php

namespace App\Enum\Blog;

enum FriendshipStatusEnum: string
{
    case Pending = 'pending';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
}
