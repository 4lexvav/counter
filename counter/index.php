<?php
session_start();

ini_set('log_errors', 1);
ini_set('error_log', 'log/error.log');

require __DIR__.'/vendor/autoload.php';

$app = new Counter\App();

$app->run();
