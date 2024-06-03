<?php

declare(strict_types=1);

namespace App\Application\HtmlDomParser\Response;

class DomParserIdNewsResponse
{
    public function __construct
    (
        public int $id
    )
    {}
}