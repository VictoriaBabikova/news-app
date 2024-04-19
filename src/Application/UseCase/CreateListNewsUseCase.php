<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\HtmlDomParser\HtmlDomParserInterface;
use App\Application\UseCase\Request\CreateListNewsRequest;
use App\Application\UseCase\Response\CreateListNewsResponse;
class CreateListNewsUseCase
{
    private HtmlDomParserInterface $htmlDomParser;
    private string $file;

    public function __construct(HtmlDomParserInterface $htmlDomParser) {
        $this->htmlDomParser = $htmlDomParser;
        $this->file = dirname(__DIR__, 3) ."/". $_ENV['STORAGE_PATH'];
    }
    public function __invoke(CreateListNewsRequest $request): CreateListNewsResponse
    {
        $arrayList = $request->arrayList;

        if (file_exists($this->file)) {
            $html = $this->htmlDomParser->parse($this->file);
            $array = $html->find('div');

            foreach ($array as $key => $element) {
                $arrayList[$key]['id'] = $element->find('p', 0)->getAttribute('id');
                $arrayList[$key]['date'] = $element->find('p', 0)->text();
                $arrayList[$key]['address'] = $element->find('a')[0]->href;
                $arrayList[$key]['name'] = $element->find('a')[0]->text();
            }
        }

        return new CreateListNewsResponse(
            $arrayList
        );
    }
}
