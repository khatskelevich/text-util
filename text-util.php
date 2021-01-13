<?php

spl_autoload_register(function ($class) {
    include 'app/' . $class . '.php';
});

try {
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
                throw new Exception('Невалидный первый аргумент. Используйте comma/semicolon');
        }

        $files = new Files('texts');

        switch ($argv[2]) {
            case 'countAverageLineCount':
                countAverageLineCount($csv->getUsers(), $files);
                break;
            case 'replaceDates':
                $files->replaceDates(basicFormat: 'd/m/y', destinationFormat: 'm-d-y');
                break;
            default:
                throw new Exception('Невалидный второй аргумент: ' . $argv[2] . ' Используйте countAverageLineCount/replaceDates');
        }
    } else throw new Exception('Некорректное количество аргументов');
} catch (Exception $e) {
    exit($e->getMessage());
}

/**
 * @param $users
 * @param Files $files
 * @throws Exception
 */
function countAverageLineCount($users, Files $files)
{
    echo "\nСреднее количество строк в тексте для каждого пользователя\n\n";
    foreach ($users as $user) {
        echo $user['name'] . ': ' . $files->averageLineCount($user['id']) . "\n";
    }
}