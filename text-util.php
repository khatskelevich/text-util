<?php

spl_autoload_register(function ($class) {
    include 'app/' . $class . '.php';
});

$app = new Application($argv);
$app->start();