<?php


namespace Application\Business\PostAction;


use Application\Models\{PostActionRecord as PAR, User};
use Routeless\Core\Exceptions\HttpException;

/**
 * Trait DoAction
 * @package Application\Business\PostAction
 * @mixin BaseAction
 */
trait DoAction {
    public function do(User $actUser) {
        $post = $this->post;
        $record = PAR::findOneAction($this->getActionType(), $post->id, $actUser->id);
        if ($record) {
            throw new HttpException(400, '已经做过了');
        }
        $record = new PAR();
        $record->actionType = $this->getActionType();
        $record->postId = $post->id;
        $record->actionUserId = $actUser->id;
        $record->save();

        return $record;
    }
}