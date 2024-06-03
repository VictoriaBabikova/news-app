<?php

declare(strict_types=1);

namespace App\Application\HtmlDomParser\Request;

class DomParserFileNameRequest
{
    public function __construct
    (
        public readonly string $fileName
    )
    {}
}
