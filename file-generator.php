<?php

function generateText(): string
{
    $text = "";
    $stringCount = mt_rand(0, 1000);
    for ($i = 0; $i < $stringCount; $i++) {
        $text = $text . "\n" . md5(rand());
    }
    return "13/01/20\n" . $text;
}

for ($i = 1; $i <= 20; $i++) {
    $textsCount = rand(0, 10);
    for ($j = 1; $j <= $textsCount; $j++) {
        $filename = $i . '-' . str_pad($j, 4, '0', STR_PAD_LEFT) . '.txt';
        $fp = fopen('texts\\' . $filename, 'w');
        fwrite($fp, generateText());
        fclose($fp);
    }
}


