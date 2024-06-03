<?php

declare(strict_types=1);

namespace App\Application\HtmlDomParser\Response;

class DomParserListNewsResponse
{
    public function __construct
    (
        public readonly array $arrayList
    )
    {}
}
