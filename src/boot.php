<?php

require __DIR__ . "/../vendor/autoload.php";
define('CFG_PATH', realpath(__DIR__ . '/../config'));

use Routeless\Services\Cfg;
use Services\Sms;


$app = new Routeless\Core\Application(CFG_PATH);

\Routeless\Services\DB::boot(Cfg::get('database.mysql'));
\Routeless\Services\Redis::boot(Cfg::get('database.redis'));

Sms::init('qq', Cfg::get('app.sms.app_id'), Cfg::get('app.sms.key'));

return $app;

