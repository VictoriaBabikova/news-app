<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\CreateNewsReportRequest;
use App\Application\UseCase\Response\CreateNewsReportResponse;
use App\Domain\Repository\NewsRepositoryInterface;
use Exception;

class CreateNewsReportUseCase
{
    private NewsRepositoryInterface $newsRepository;
    public function __construct(NewsRepositoryInterface $newsRepository) {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @throws Exception
     */
    public function __invoke(CreateNewsReportRequest $request): CreateNewsReportResponse
    {
        $arrayList = json_decode($request->ids_list);
        $arrayList = $this->newsRepository->findNewsByArrayOfId($arrayList);

        return new CreateNewsReportResponse(
            $this->newsRepository->saveNewsInReport($arrayList)
        );
    }
}
