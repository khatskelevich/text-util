<?php

spl_autoload_register(function ($class) {
    include 'app/' . $class . '.php';
});

if (count($argv) == 3) {
    switch ($argv[1]) {
        case 'comma':
        case ',':
            $csv = new ParseCSV('people.csv', ',');
            break;
        case 'semicolon':
        case ':':
            $csv = new ParseCSV('people.csv', ':');
            break;
        default:
            exit('Невалидный первый аргумент. Используйте comma/semicolon');
    }

    $files = new Files('texts');

    switch ($argv[2]) {
        case 'countAverageLineCount':
            countAverageLineCount($csv->getUsers(), $files);
            break;
        case 'replaceDates':
            //TODO Функция replaceDates
            break;
        default:
            exit('Невалидный второй аргумент: ' . $argv[2] . ' Используйте countAverageLineCount/replaceDates');
    }


} else exit('Некорректное количество аргументов');

function countAverageLineCount($users, Files $files)
{
    foreach ($users as $user) {
        echo $user['name'] . ': ' . $files->averageLineCount($user['id']) . "\n";
    }
}