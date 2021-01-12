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
     * @param $path
     * @return array
     */
    protected function getFilesNameFromPath($path): array
    {
        $files = [];
        foreach (glob($path) as $file) {
            if (is_file($file)) {
                $files[] = basename($file);
            }
        }
        return $files;
    }

    /**
     * @param $id
     * @param string $extension Тип файлов
     * @return array Список названий файлов содержащих id
     */
    protected function findById($id, $extension = 'txt'): array
    {
        $path = $this->dirname . '/' . $id . '-*' . ($extension != '' ? $extension : '');
        return $this->getFilesNameFromPath($path);
    }

    /**
     * @param string $extension Тип файлов
     * @return array Список файлов
     */
    protected function findAll($extension = ''): array
    {
        $path = $this->dirname . '/*' . ($extension != '' ? $extension : '');
        return $this->getFilesNameFromPath($path);
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
     * @param string $extension
     * @return float
     * @throws Exception
     */
    public function averageLineCount($id, $extension = 'txt'): float
    {
        $count = 0;
        $i = 0;
        foreach ($this->findById($id, $extension) as $file) {
            $count += $this->lineCount($file);
            $i++;
        }

        return $i != 0 ? $count / $i : 0;
    }

    /**
     * Заменяет в каждом тексте даты в формате dd/mm/yy на даты в формате mm-dd-yyyy
     * @param string $regexp Маска для поиска даты.
     * @param string $basicFormat Формат даты(DateTime) соответствующий маске
     * @param string $destinationFormat Требуемый формат даты(DateTime)
     * @throws Exception
     */
    public function replaceDates($regexp = '/\d{2}\/\d{2}\/\d{2,4}/', string $basicFormat = 'm/d/y', string $destinationFormat = 'd-m-y')
    {
        foreach ($this->findAll() as $file) {
            $text = file($this->dirname . '/' . $file);
            if (is_array($text)) {
                foreach ($text as $key => $value) {
                    $text[$key] = preg_replace_callback($regexp, function ($matches) use ($destinationFormat, $basicFormat) {
                        $date = DateTime::createFromFormat($basicFormat, $matches[0]);
                        return $date->format($destinationFormat);
                    }, $value);
                }
            } else {
                throw new Exception('Ошибка чтения файла: ' . $this->dirname . '/' . $file);
            }
            $fp = fopen('output_texts\\' . $file, 'w');
            fwrite($fp, implode('', $text));
            fclose($fp);
        }
    }

}