<?php

namespace App\Infrastructure\FileCreator;

trait FileCreator
{
    private function getPatternDoc(): string
    {
        return '<!doctype html>
<html lang="en">
    <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
       <meta http-equiv="X-UA-Compatible" content="ie=edge">
       <title>News</title>
    </head>
    <body>
    </body>
</html>';
    }

    private function saveFileWithNewData(string $file, string $substr, string $attachment, string $data): void
    {
        $newstring = str_replace($substr, $substr.$attachment, $data);

        $myfile = fopen($file, "w+") or die("Unable to open file!");
        fwrite($myfile, $newstring);
        fclose($myfile);
    }
}
