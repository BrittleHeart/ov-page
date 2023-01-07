<?php

namespace App\Enum\Blog;

enum CommentStatusEnum: int
{
    case Submitted = 1;
    case Approved = 2;
    case Rejected = 3;
}
