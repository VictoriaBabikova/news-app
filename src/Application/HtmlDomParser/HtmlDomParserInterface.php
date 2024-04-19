<?php

namespace App\Application\HtmlDomParser;

interface HtmlDomParserInterface
{
    public function parse(string $html): object;
}
