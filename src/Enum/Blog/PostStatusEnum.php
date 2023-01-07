<?php

namespace App\Enum\Blog;

enum PostStatusEnum: int
{
    case Draft = 1;
    case Published = 2;
    case Archived = 3;
}
