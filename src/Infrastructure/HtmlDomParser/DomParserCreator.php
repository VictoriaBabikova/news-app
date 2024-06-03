<?php

declare(strict_types=1);

namespace App\Infrastructure\HtmlDomParser;

use App\Application\HtmlDomParser\DomParserInterface;
use App\Application\HtmlDomParser\Request\DomParserFileNameRequest;
use App\Application\HtmlDomParser\Request\DomParserIdNewsListRequest;
use App\Application\HtmlDomParser\Response\DomParserHtmlResponse;
use App\Application\HtmlDomParser\Response\DomParserIdNewsResponse;
use App\Application\HtmlDomParser\Response\DomParserListNewsResponse;
use App\Application\HtmlDomParser\Response\DomParserNewsResponse;
use App\Application\HtmlDomParser\Response\DomParserTitleNewsResponse;
use Exception;
use voku\helper\HtmlDomParser;

class DomParserCreator implements DomParserInterface
{
    /**
     * @throws Exception
     */
    public function parse(string $fileName): HtmlDomParser
    {
        $page = file_get_contents($fileName);
        return HtmlDomParser::str_get_html($page);
    }

    /**
     * @throws Exception
     */
    public function parseTitle(DomParserFileNameRequest $fileNameRequest): DomParserTitleNewsResponse
    {
        $html = $this->parse($fileNameRequest->fileName);

        $title = $html->find('title')->text()[0];

        return new DomParserTitleNewsResponse(
            $title
        );
    }

    /**
     * @throws Exception
     */
    public function parseDiv(DomParserFileNameRequest $fileNameRequest, DomParserIdNewsListRequest $idNewsListRequest = null): DomParserListNewsResponse
    {
        $html = $this->parse($fileNameRequest->fileName);
        $array = $html->find('div');
        $arrayList = [];
        $arrayNewsData = [];

        if ($idNewsListRequest) {
            foreach ($idNewsListRequest->arrayList as $id) {
                foreach ($array as $key => $element) {
                    if ($id == $element->find('p', 0)->getAttribute('id')) {
                        $arrayList[$key]['id'] = $element->find('p', 0)->getAttribute('id');
                        $arrayList[$key]['date'] = $element->find('p', 0)->text();
                        $arrayList[$key]['address'] = $element->find('a')[0]->href;
                        $arrayList[$key]['name'] = $element->find('a')[0]->text();

                        $arrayNewsData[] = new DomParserNewsResponse($arrayList[$key]);
                    }
                }
            }
        } else {
            foreach ($array as $key => $element) {
                $arrayList[$key]['id'] = $element->find('p', 0)->getAttribute('id');
                $arrayList[$key]['date'] = $element->find('p', 0)->text();
                $arrayList[$key]['address'] = $element->find('a')[0]->href;
                $arrayList[$key]['name'] = $element->find('a')[0]->text();

                $arrayNewsData[] = new DomParserNewsResponse($arrayList[$key]);
            }
        }

        return new DomParserListNewsResponse(
            $arrayNewsData
        );
    }

    /**
     * @throws Exception
     */
    public function parseId(DomParserFileNameRequest $fileNameRequest): DomParserIdNewsResponse
    {
        $html = $this->parse($fileNameRequest->fileName);

        $idOfNews = $html->find('p', 0)->getAttribute('id');

        return new DomParserIdNewsResponse(
            (int)$idOfNews
        );
    }

    /**
     * @throws Exception
     */
    public function parseHtml(DomParserFileNameRequest $fileNameRequest): DomParserHtmlResponse
    {
        $html = $this->parse($fileNameRequest->fileName);
        $string = $html->html();

        return new DomParserHtmlResponse(
            $string
        );
    }
}
