<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\HtmlDomParser\Request\DomParserFileNameRequest;
use Exception;
use App\Application\UseCase\Request\CreateNewsRequest;
use App\Application\UseCase\Response\CreateNewsResponse;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\Name;
use App\Application\HtmlDomParser\DomParserInterface;

class CreateNewsUseCase
{
    private NewsRepositoryInterface $newsRepository;
    private DomParserInterface $htmlDomParser;
    public function __construct(NewsRepositoryInterface $newsRepository, DomParserInterface $htmlDomParser) {
        $this->newsRepository = $newsRepository;
        $this->htmlDomParser = $htmlDomParser;
    }

    /**
     * @throws Exception
     */
    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        $fileName = new DomParserFileNameRequest($request->address);

        $title = $this->htmlDomParser->parseTitle($fileName);

        $news = new News(
            new Name($title->title),
            new Address($request->address)
        );

        $this->newsRepository->save($news);

        return new CreateNewsResponse(
            $news->getId()
        );
    }
}
