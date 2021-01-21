<?php


class Application
{
    private $method;
    private $delimiter;
    private string $dirname = 'texts';

    public function __construct($argv)
    {
        if (count($argv) >= 3) {
            $this->delimiter = $argv[1];
            $this->method = $argv[2];
        } else exit('Некорректное количество аргументов');
    }

    public function start()
    {
        try {
            switch ($this->method) {
                case 'countAverageLineCount':
                    $this->countAverageLineCount();
                    break;
                case 'replaceDates':
                    $this->replaceDates();
                    break;
                default:
                    throw new Exception('Невалидный второй аргумент: ' . $this->method . ' Используйте countAverageLineCount/replaceDates');
            }
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    private function countAverageLineCount()
    {
        $csv = match ($this->delimiter) {
            'comma', ',' => new ParseCSV('people.csv', ','),
            'semicolon', ':' => new ParseCSV('people.csv', ':'),
            default => throw new Exception('Невалидный первый аргумент. Используйте comma/semicolon'),
        };
        $users = $csv->getUsers();

        $files = new Files($this->dirname);

        echo "\nСреднее количество строк в тексте для каждого пользователя\n\n";
        foreach ($users as $user) {
            echo $user['name'] . ': ' . $files->averageLineCount($user['id']) . "\n";
        }
    }

    /**
     * @throws Exception
     */
    private function replaceDates(){
        $files = new Files($this->dirname);

        $files->replaceDates(basicFormat: 'd/m/y', destinationFormat: 'm-d-y');
    }
}