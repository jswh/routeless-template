<?php


namespace Application\Business\PostAction;

use Application\Models\{PostActionRecord as PAR, User};
use Routeless\Core\Exceptions\HttpException;

/**
 * Trait UndoAction
 * @package Application\Business\PostAction
 * @mixin BaseAction
 */
trait UndoAction {
    public function do(User $actUser) {
        $record = PAR::findOneAction($this->getActionType(), $this->post->id, $actUser->id);
        if (!$record) {
            throw new HttpException(404, "没有操作记录");
        }
        return $record->remove();
    }
}