<?php
require __DIR__ . "/../../vendor/autoload.php";
use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Migrations\{ DatabaseMigrationRepository, Migrator, MigrationCreator};
use Illuminate\Database\Schema\Builder;

$app = require __DIR__ . '/../boot.php';

$cfg = require __DIR__ . '/../../config/database.php';
$path = __DIR__ . '/Schemas';
$migration = boot($cfg, $path);

if (count($argv) < 2) {
    usage();
} else {
    switch ($argv[1]) {
        case 'run':
            $migration->run($path);
            break;
        case 'make':
            $name = $argv['2'] ?? null;
            if ($name) {
                $creator = new MigrationCreator($migration->getFilesystem());
                $creator->create($name, $path);
            } else {
                usage();
            }
            break;
        default:
            usage();
    }
}

function usage() {
    $commandBase = 'php migrate.php';
    echo "usage: \n $commandBase run \n $commandBase make [name] \n";
}

function boot($cfg, $path) {

    $files = new Filesystem();
    $files->files($path);

    $dbFactory = new ConnectionFactory(new \Illuminate\Container\Container());
    $conn = $dbFactory->make($cfg['mysql']);

    $db = new ConnectionResolver(['mysql' => $conn]);
    $db->setDefaultConnection('mysql');

    $repository = new DatabaseMigrationRepository($db, 'migrations');
    $m = new Migrator($repository, $db, $files);

    if (!$repository->repositoryExists()) {
        $repository->createRepository();
    }

    return $m;
}
class Schema {
    public static function table($table, callable $callback) {
        global $cfg;
        $dbFactory = new ConnectionFactory(new \Illuminate\Container\Container());
        $conn = $dbFactory->make($cfg['mysql']);
        $builder = $conn->getSchemaBuilder();
        $builder->table($table, $callback);
    }

    public static function create($table, callable $callback) {
        global $cfg;
        $dbFactory = new ConnectionFactory(new \Illuminate\Container\Container());
        $conn = $dbFactory->make($cfg['mysql']);

        $builder = $conn->getSchemaBuilder();
        $builder->create($table, $callback);
    }

}

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