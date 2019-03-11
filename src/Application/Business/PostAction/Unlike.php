<?php


namespace Application\Business\PostAction;


use Application\Models\PostActionRecord;

class Unlike extends BaseAction {
    use UndoAction;

    public function getActionType() {
        return PostActionRecord::TYPE_LIKE;
    }
}