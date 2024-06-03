<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\HtmlDomParser\DomParserInterface;
use App\Application\HtmlDomParser\Request\DomParserFileNameRequest;
use App\Application\HtmlDomParser\Request\DomParserIdNewsListRequest;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\FileCreator\FileCreator;

class NewsRepository implements NewsRepositoryInterface
{
    use FileCreator;

    private string $file;
    private DomParserInterface $htmlDomParser;
    private DomParserFileNameRequest $fileName;

    public function __construct(DomParserInterface $htmlDomParser)
    {
        $this->file = dirname(__DIR__, 3) ."/". $_ENV['STORAGE_PATH'];
        $this->fileName = new DomParserFileNameRequest($this->file);
        $this->htmlDomParser = $htmlDomParser;
    }

    public function save(News $news): void
    {
        if (!file_get_contents($this->file)) {
            $idOfNews = 0;
            $string = $this->getPatternDoc();
        } else {
            $string = $this->htmlDomParser->parseHtml($this->fileName);
            $idOfNews = $this->htmlDomParser->parseId($this->fileName);
        }

        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, ++$idOfNews->id);

        $new_news = "<hr><div><p id='{$news->getId()}'>created at {$news->getDate()->format('Y-m-d')}</p><a href='{$news->getAddress()->__toString()}'>{$news->getName()->__toString()}</a></div>\n";

        $this->saveFileWithNewData($this->file,"<body>\n", $new_news, $string->html);
    }

    public function findNewsByArrayOfId(array $arrayId): array
    {
        $arrayList = new DomParserIdNewsListRequest($arrayId);

        $arrayNews = $this->htmlDomParser->parseDiv($this->fileName, $arrayList);

        if (empty($arrayNews->arrayList)) {
            return [];
        }

        return $arrayNews->arrayList;
    }

    public function findNews(): array
    {
        $arrayNews = $this->htmlDomParser->parseDiv($this->fileName);

        if (empty($arrayNews->arrayList)) {
            return [];
        }

        return $arrayNews->arrayList;
    }
}
