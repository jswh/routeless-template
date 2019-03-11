<?php


namespace Application\Business\PostAction;


use Application\Models\PostActionRecord;

class Like extends BaseAction {
    use DoAction;

    public function getActionType() {
        return PostActionRecord::TYPE_LIKE;
    }
}