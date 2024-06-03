<?php

declare(strict_types=1);

namespace App\Application\HtmlDomParser\Response;

class DomParserTitleNewsResponse
{
    public function __construct
    (
        public readonly string $title
    )
    {}
}