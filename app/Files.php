<?php

class Files
{
    /**
     * Files constructor.
     * @param string $dirname
     * @throws Exception
     */
    public function __construct(private string $dirname = '')
    {
        if (!is_dir($this->dirname)) throw new Exception('Директории ' . $dirname . ' не существует');
    }

    /**
     * @param $id
     * @return array
     */
    protected function findById($id): array
    {
        $files = [];
        foreach (glob($this->dirname . '/' . $id . '-*.txt') as $file) {
            if (is_file($file)) {
                $files[] = basename($file);
            }
        }
        return $files;
    }

    /**
     * @param $file
     * @return int
     * @throws Exception
     */
    protected function lineCount($file): int
    {
        if (!file_exists($this->dirname . '/' . $file)) throw new Exception('Файл ' . $file . ' не существует');
        $text = file($this->dirname . '/' . $file);
        return count($text);
    }

    /**
     * @param $id
     * @return float
     * @throws Exception
     */
    public function averageLineCount($id): float
    {
        $count = 0;
        $i = 0;
        foreach ($this->findById($id) as $file) {
            $count += $this->lineCount($file);
            $i++;
        }

        return $i != 0 ? $count / $i : 0;
    }
}