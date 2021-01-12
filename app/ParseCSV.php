<?php


class ParseCSV
{
    public function __construct(private string $filename, private string $separator = ',')
    {
    }

    /**
     * @throws Exception
     */
    protected function parse(): array
    {
        $data = [];

        if (($file = fopen($this->filename, 'r')) != false) {
            while (($lines = fgetcsv($file, 0, $this->separator)) != false) {
                $data[] = $lines;
            }
            fclose($file);
        } else {
            throw new Exception('Не удалось открыть файл ' . $this->filename);
        }

        return $data;
    }


    /**
     * Обертка для получения ассоциативного массива ['id' => .. , 'name' => .. ]
     * @throws Exception
     */
    public function getUsers(): array
    {
        return array_map(function ($v) {
            return array_combine(['id', 'name'], $v);
        }, $this->parse());
    }
}