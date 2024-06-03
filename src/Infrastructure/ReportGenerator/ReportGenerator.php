<?php

declare(strict_types=1);

namespace App\Infrastructure\ReportGenerator;

use App\Application\ReportGenerator\ReportGeneratorInterface;
use App\Infrastructure\FileCreator\FileCreator;

class ReportGenerator implements ReportGeneratorInterface
{
    use FileCreator;

    private string $file_report;

    public function __construct()
    {
        $this->file_report = dirname(__DIR__, 3) ."/". $_ENV['REPORT_PATH'];
    }
    public function saveNewsInReport(array $arrayList): string
    {
        $string = $this->getPatternDoc();
        $new_str = '';

        foreach ($arrayList as $array) {
            foreach ($array as $value) {
                $new_str .= "\n<hr><div><p id='{$value['id']}'>{$value['date']}</p><a href='{$value['address']}'>{$value['name']}</a></div>\n";
            }
        }

        $this->saveFileWithNewData($this->file_report,"<body>",  $new_str, $string);

        return $this->file_report;
    }
}
