<?php


namespace Application\Business;


use Application\Business\PostAction\{Like, Unlike, View};
use Application\Models\Post;
use Application\Models\User;

class ActionRecordService {
    public function __construct(Post $post, User $user = null) {
        $this->post = $post;
        $this->user = $user;
    }

    public function likeUserIds() {
        return (new Like($this->post))->actUserList();
    }

    public function viewUserIds() {
        return (new View($this->post))->actUserList();
    }

    public function actLike() {
        $this->checkUser();
        return (new Like($this->post))->do($this->user);
    }

    public function actUnlike() {
        $this->checkUser();
        return (new Unlike($this->post))->do($this->user);
    }

    public function actView() {
        $this->checkUser();
        return (new View($this->post))->do($this->user);
    }

    protected function checkUser() {
        if (!$this->user) {
            throw new \Exception('act show initial by user');
        }
    }
}