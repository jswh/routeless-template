<?php


namespace Application\Models\Helpers;

/**
 * Trait ExtraColumnHelper
 * @package Application\Models\Helpers
 */
trait ExtraColumnHelper {
    public $extra;
    protected $extracted = null;

    public function afterLoad() {
        $this->loadExtra();
    }

    public function beforeSave() {
        $this->extra = json_encode($this->extracted, JSON_UNESCAPED_UNICODE);
    }

    protected function loadExtra() {
        $this->extracted = @json_decode($this->extra, true) ?: [];
    }

    public function __get($name) {
        return $this->extracted[$name] ?? null;
    }

    public function __set($name, $value) {
        if (!$this->isAppend($name)) {
            return null;
        }

        $this->extracted[$name] = $value;
        return $value;
    }

    protected function isAppend($name) {
        return in_array($name, $this->appends);
    }
}