<?php


class ParseCSV
{
    public function __construct(private string $filename)
    {}

    public function parse(): array
    {
        $data = [];

        if (($file = fopen($this->filename, 'r')) != false) {
            while (($data[] = fgetcsv($file)) != false) {
            }
            fclose($file);
        } else {
            throw new Exception('Не удалось открыть файл ' . $this->filename);
        }

        return $data;
    }
}