<?php


namespace Application\Business\PostAction;


use Application\Models\Post;
use Application\Models\PostActionRecord as PAR;
use Application\Models\User;

abstract class BaseAction {

    public function __construct(Post $post) {
        $this->post = $post;
    }

    public function actUserList() {
        return PAR::findActions($this->getActionType(), $this->post->id)
            ->pluck('actionUserId')
            ->toArray();
    }

    abstract function do(User $actUser);
    abstract function getActionType();
}