<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\HtmlDomParser\HtmlDomParserInterface;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use Exception;

class InMemoryNewsRepository implements NewsRepositoryInterface
{
    /**
     * @var string
     */
    private string $file;
    private string $file_report;
    private HtmlDomParserInterface $htmlDomParser;

    public function __construct(HtmlDomParserInterface $htmlDomParser)
    {
        $this->file = dirname(__DIR__, 3) ."/". $_ENV['STORAGE_PATH'];
        $this->file_report = dirname(__DIR__, 3) ."/". $_ENV['REPORT_PATH'];
        $this->htmlDomParser = $htmlDomParser;
    }
    /**
     * @throws Exception
     */
    public function save(News $news): void
    {
        if (file_exists($this->file)) {
            if (!file_get_contents($this->file)) {
                $idOfNews = 0;
                $string = $this->getPatternDoc();
            } else {
                $html = $this->htmlDomParser->parse($this->file);
                $string = $html->html();
                $idOfNews = $html->find('p', 0)->getAttribute('id');
            }

            $reflectionProperty = new \ReflectionProperty(News::class, 'id');
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($news, ++$idOfNews);

            $new_news = "<hr><div><p id='{$news->getId()}'>created at {$news->getDate()}</p><a href='{$news->getAddress()->__toString()}'>{$news->getName()->__toString()}</a></div>\n";

            $this->saveFileWithNewData($this->file,"<body>\n", $new_news, $string);

        } else {
            throw new Exception("File $this->file not found");
        }
    }

    /**
     * @throws Exception
     */
    public function findNewsByArrayOfId(array $arrayId): array
    {
        $arrayList = [];
        if (file_exists($this->file)) {
            $html =$this->htmlDomParser->parse($this->file);
            $array = $html->find('div');

            foreach ($arrayId as $id) {
                foreach ($array as $key => $element) {
                    if ($id == $element->find('p', 0)->getAttribute('id')) {
                        $arrayList[$key]['id'] = $element->find('p', 0)->getAttribute('id');
                        $arrayList[$key]['date'] = $element->find('p', 0)->text();
                        $arrayList[$key]['address'] = $element->find('a')[0]->href;
                        $arrayList[$key]['name'] = $element->find('a')[0]->text();
                    }
                }
            }
            return $arrayList;
        } else {
            throw new Exception("File $this->file not found");
        }
    }

    public function saveNewsInReport(array $arrayList): string
    {
        $string = $this->getPatternDoc();
        $new_str = '';
        foreach ($arrayList as $array) {
            $new_str .= "\n<hr><div><p id='{$array['id']}'>{$array['date']}</p><a href='{$array['address']}'>{$array['name']}</a></div>\n";
        }

        $this->saveFileWithNewData($this->file_report,"<body>",  $new_str, $string);

        return $this->file_report;
    }

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
