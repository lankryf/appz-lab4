<?php

use Bubblegum\App;
use Bubblegum\Database\DB;
use Bubblegum\Environment;

session_start();
require_once "../vendor/autoload.php";
require_once "../app/routes.php";

define("ROOT_PATH", dirname(__DIR__, 1) . DIRECTORY_SEPARATOR);

Environment::loadIfNotPrevented(ROOT_PATH . '.env');

DB::initPDO();

App::run();