<?php

spl_autoload_register(function ($class) {
    include 'app/' . $class . '.php';
});

$csv = new ParseCSV('people.csv');
$files = new Files('texts');