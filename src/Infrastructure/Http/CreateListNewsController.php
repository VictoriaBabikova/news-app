<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\ListNewsUseCase;
use App\Application\UseCase\Request\CreateListNewsRequest;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

class CreateListNewsController extends AbstractFOSRestController
{
    public function __construct(
        private ListNewsUseCase $useCase,
    )
    {}

    /**
     * @Rest\Get("/api/v1/news/list")
     * @param CreateListNewsRequest $request
     * @return Response
     */
    public function __invoke(CreateListNewsRequest $request): Response
    {
        try {
            $response = ($this->useCase)($request);
            $view = $this->view($response, 201);
        } catch (\Throwable $e) {
            // todo В реальности используются более сложные обработчики ошибок
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            $view = $this->view($errorResponse, 400);
        }
        return $this->handleView($view);
    }
}
