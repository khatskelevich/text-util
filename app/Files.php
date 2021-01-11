<?php

class Files
{
    public function __construct(private string $dirname){
    }

    public function findById($id) :array
    {
        $files = [];
        foreach(glob($this->dirname.'/*') as $file) {
            if (is_file($file)) {
                $files[] = basename($file);
            }
        }

        return $files;
    }
}