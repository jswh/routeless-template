<?php
/**
 * Class Table
 * @mixin \Illuminate\Database\Schema\Blueprint
 */
class Table {
    public $table;
    public function __construct(\Illuminate\Database\Schema\Blueprint $table) {
        $this->table = $table;
    }

    public function id($name = 'id') {
        $this->table->increments($name);
    }

    public function timestamps() {
        $this->table->integer('createdTime')->nullable();
        $this->table->integer('updatedTime')->nullable();
    }

    public function relation($name) {
        return $this->table->integer($name, false, true);
    }

    public function __call($name, $arguments) {
        return call_user_func_array([$this->table, $name], $arguments);
    }
}
