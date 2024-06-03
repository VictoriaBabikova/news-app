<?php

declare(strict_types=1);

namespace App\Application\HtmlDomParser;

use App\Application\HtmlDomParser\Request\DomParserFileNameRequest;
use App\Application\HtmlDomParser\Request\DomParserIdNewsListRequest;
use App\Application\HtmlDomParser\Response\DomParserHtmlResponse;
use App\Application\HtmlDomParser\Response\DomParserIdNewsResponse;
use App\Application\HtmlDomParser\Response\DomParserListNewsResponse;
use App\Application\HtmlDomParser\Response\DomParserTitleNewsResponse;

interface DomParserInterface
{
    public function parse(string $fileName): object;

    public function parseTitle(DomParserFileNameRequest $fileNameRequest): DomParserTitleNewsResponse;

    public function parseDiv(DomParserFileNameRequest $fileNameRequest, DomParserIdNewsListRequest $idNewsListRequest = null): DomParserListNewsResponse;

    public function parseId(DomParserFileNameRequest $fileNameRequest): DomParserIdNewsResponse;

    public function parseHtml(DomParserFileNameRequest $fileNameRequest): DomParserHtmlResponse;
}
