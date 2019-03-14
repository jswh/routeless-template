<?php

require __DIR__ . "/../vendor/autoload.php";
define('CFG_PATH', realpath(__DIR__ . '/../config'));

use Routeless\Services\Cfg;


$app = new Routeless\Core\Application(CFG_PATH);
\Routeless\Services\DB::boot(Cfg::get('database.' . env('DB_NAME')));
\Routeless\Services\Redis::boot(Cfg::get('database.redis'));


return $app;

