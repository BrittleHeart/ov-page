<?php

namespace App\Enum\Blog\Histories;

enum PostHistoryActionEnum: string
{
    case Created = 'created';
    case Updated = 'updated';
    case Published = 'published';
    case Unpublished = 'unpublished';
    case AddedTag = 'added_tag';
    case RemovedTag = 'removed_tag';
    case AssignedCategory = 'assigned_category';
    case RemovedCategory = 'removed_category';
    case AddedAttachment = 'added_attachment';
    case RemovedAttachment = 'removed_attachment';
    case AddedComment = 'added_comment';
    case RemovedComment = 'removed_comment';
    case AddedLike = 'added_like';
    case RemovedLike = 'removed_like';
    case AddedShare = 'added_share';
    case RemovedShare = 'removed_share';
    case Deleted = 'deleted';
}
