<?php

declare(strict_types=1);

namespace App\Application\HtmlDomParser\Response;

class DomParserHtmlResponse
{
    public function __construct
    (
        public readonly string $html
    )
    {}
}