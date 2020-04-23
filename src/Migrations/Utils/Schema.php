<?php
class Schema {
    static $conn = null;
    public static function table($table, Closure $callback) {
        $builder = self::$conn->getSchemaBuilder();
        $builder->table($table, $callback);
    }

    public static function create($table, Closure $callback) {
        $builder = self::$conn->getSchemaBuilder();
        $builder->create($table, $callback);
    }

    public static function dropIfExists($table) {
        $builder = self::$conn->getSchemaBuilder();
        $builder->dropIfExists($table);
    }
}

