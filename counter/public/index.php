<?php
session_start();

ini_set('log_errors', 1);
ini_set('error_log', '../log/error.log');

putenv('APP_ROOT_PATH='.dirname(__DIR__));

require '../vendor/autoload.php';

$app = new Counter\App();

$app->run();
