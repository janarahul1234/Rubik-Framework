<?php

define('ROOT_DIR', dirname(__DIR__));

require_once ROOT_DIR . '/vendor/autoload.php';
require_once ROOT_DIR . '/app/core/service/__autoload.php';

use App\core\utils\Env;
use App\core\Application;
Env::config();

autoload('/app/core/service');
autoload('/routes');

$app = new Application();
$app->run();
