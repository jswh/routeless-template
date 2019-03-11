<?php
namespace Application\Models;


use Application\Models\Helpers\Timestamps;
use Routeless\Core\Model;

class Comment extends Model
{
    use Timestamps;
    protected $table = "comment";
    const TYPE_TEXT = 1;
    const TYPE_PIC = 2;
    const STATUS_NORMAL = 1;
    public
        $id,
        $userId,
        $commentToPostId,
        $status,
        $type,
        $replyToUserId,
        $replyToCommentId,
        $mediaId,
        $content;

    /**
     * @param Post $post
     * @param User $user
     * @param string $content
     * @return Comment
     */
    public static function create(Post $post, User $user, $content) {
        $comment = new Comment();
        $comment->userId = $user->id;
        $comment->commentToPostId = $post->id;
        $comment->type = Comment::TYPE_TEXT;
        $comment->status = Comment::STATUS_NORMAL;
        $comment->content = $content;
        $comment->save();
        return $comment;
    }

    public static function createReply(Comment $comment, User $user, $content) {
        $reply = new Comment();
        $reply->userId = $user->id;
        $reply->commentToPostId = $comment->commentToPostId;
        $reply->type = Comment::TYPE_TEXT;
        $reply->status = Comment::STATUS_NORMAL;
        $reply->replyToCommentId = $comment->id;
        $reply->replyToUserId = $user->id;
        $reply->content = $content;
        $reply->save();
        return $reply;
    }
}