<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use Exception;
use App\Application\UseCase\Request\CreateNewsRequest;
use App\Application\UseCase\Response\CreateNewsResponse;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\Name;
use App\Application\HtmlDomParser\HtmlDomParserInterface;

class CreateNewsUseCase
{
    private NewsRepositoryInterface $newsRepository;
    private HtmlDomParserInterface $htmlDomParser;
    public function __construct(NewsRepositoryInterface $newsRepository, HtmlDomParserInterface $htmlDomParser) {
        $this->newsRepository = $newsRepository;
        $this->htmlDomParser = $htmlDomParser;
    }

    /**
     * @throws Exception
     */
    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        $html = $this->htmlDomParser->parse($request->address);

        $title = $html->find('title')->text()[0];

        $news = new News(
            new Name($title),
            new Address($request->address)
        );

        $this->newsRepository->save($news);

        return new CreateNewsResponse(
            $news->getId()
        );
    }
}
