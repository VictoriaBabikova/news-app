<?php

declare(strict_types=1);

namespace App\Application\HtmlDomParser\Request;

class DomParserIdNewsListRequest
{
    public function __construct
    (
        public readonly array $arrayList = []
    )
    {}
}