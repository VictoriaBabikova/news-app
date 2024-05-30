<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\HtmlDomParser\HtmlDomParserInterface;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\FileCreator\FileCreator;
use Exception;

class NewsRepository implements NewsRepositoryInterface
{
    use FileCreator;
    /**
     * @var string
     */
    private string $file;
    private HtmlDomParserInterface $htmlDomParser;

    public function __construct(HtmlDomParserInterface $htmlDomParser)
    {
        $this->file = dirname(__DIR__, 3) ."/". $_ENV['STORAGE_PATH'];
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

            $new_news = "<hr><div><p id='{$news->getId()}'>created at {$news->getDate()->format('Y-m-d')}</p><a href='{$news->getAddress()->__toString()}'>{$news->getName()->__toString()}</a></div>\n";

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
            if (empty($arrayList)) {
                return [];
            }
            return $arrayList;
        } else {
            throw new Exception("File $this->file not found");
        }
    }
}
