<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/Utils/Migration.php';
require_once __DIR__ . '/Utils/Schema.php';
require_once __DIR__ . '/Utils/Table.php';


$dbName = env('DB_NAME', 'mysql');
$cfg = require __DIR__ . '/../../config/database.php';
$path = __DIR__ . '/Schemas';
$migration = new Migration($dbName, $cfg, $path);

if (count($argv) < 2) {
    $migration->usage();
} else {
    switch ($argv[1]) {
        case 'run':
            $migration->exec();
            break;
        case 'make':
            $name = $argv['2'] ?? null;
            if ($name) {
                $migration->createSchema($name);
                break;
            }
        default:
            $migration->usage();
    }
}

