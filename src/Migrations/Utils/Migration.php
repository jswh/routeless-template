<?php

use Illuminate\Filesystem\Filesystem;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Migrations\{ DatabaseMigrationRepository, Migrator, MigrationCreator};

class Migration {
    public $dbName, $cfg, $schemaPath;
    /**
     * @param $dependencies
     */
    public function __construct($dbName, $cfg, $schemaPath)
    {
        $this->dbName = $dbName;
        $this->cfg = $cfg;
        $this->schemaPath = $schemaPath;
    }

    function usage() {
        $commandBase = 'php migrate.php';
        echo "usage: \n $commandBase run \n $commandBase make [name] \n";
    }

    function createSchema($name) {
        $path = $this->schemaPath;
        $creator = new SchemaCreator($this->filesystem());
        $create = strpos($name, 'create') !== false;
        $update = strpos($name, 'update') !== false;
        $table = ($create || $update) ? 'table_name' : null;
        $creator->create($name, $path, $table, $create);
    }

    function filesystem() {

        $files = new Filesystem();
        $files->files($this->schemaPath);

        return $files;
    }

    function exec() {
        $dbName = $this->dbName;
        $cfg = $this->cfg;
        $path = $this->schemaPath;
        $files = $this->filesystem($path);
        $dbFactory = new ConnectionFactory(new \Illuminate\Container\Container());

        $conn = $dbFactory->make($cfg[$dbName]);

        Schema::$conn = $conn;

        $db = new ConnectionResolver([$dbName => $conn]);
        $db->setDefaultConnection($dbName);

        $repository = new DatabaseMigrationRepository($db, 'migrations');
        $m = new Migrator($repository, $db, $files);

        if (!$repository->repositoryExists()) {
            $repository->createRepository();
        }

        $m->run($path);
    }
}

class SchemaCreator extends MigrationCreator {
    public function stubPath()
    {
        return __DIR__.'/Stubs';
    }
}

