<?php


namespace Application\Models\Formatters;

use Application\Models\Media;
use Application\Models\User;

/**
 * Trait UserFormatter
 * @package Application\Models\Formatters
 * @mixin User
 */
trait UserFormatter {
    public function asMiniInfo() {
        $d['id'] = $this->id;
        $d['username'] = $this->username;
        $d['avatar'] = Media::get($this->avatar)->asQiNiu();
        $d['cover'] = Media::get($this->cover)->asQiNiu();
        $d['constellation'] = $this->constellation;


        return $d;
    }
}