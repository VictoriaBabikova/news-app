<?php

declare(strict_types=1);

namespace App\Infrastructure\HtmlDomParser;

use App\Application\HtmlDomParser\HtmlDomParserInterface;
use voku\helper\HtmlDomParser;

class CreateHtmlDomParser implements HtmlDomParserInterface
{
    public function parse(string $html): HtmlDomParser
    {
        $page = file_get_contents($html);
        return HtmlDomParser::str_get_html($page);
    }
}
