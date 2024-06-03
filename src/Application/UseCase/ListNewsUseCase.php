<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Response\CreateListNewsResponse;
use App\Domain\Repository\NewsRepositoryInterface;

class ListNewsUseCase
{
    private NewsRepositoryInterface $newsRepository;

    public function __construct(NewsRepositoryInterface $newsRepository) {
        $this->newsRepository = $newsRepository;
    }
    public function __invoke(): CreateListNewsResponse
    {
        $arrayList = $this->newsRepository->findNews();

        return new CreateListNewsResponse(
            $arrayList
        );
    }
}
