<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Application\UseCase\CreateNewsUseCase;
use App\Application\UseCase\Request\CreateNewsRequest;

class CreateNewsController extends AbstractFOSRestController
{
    public function __construct(
        private CreateNewsUseCase $useCase
    )
    {}

    /**
     * @Rest\Post("/api/v1/news")
     * @ParamConverter("request", converter="fos_rest.request_body")
     * @param CreateNewsRequest $request
     * @return Response
     */
    public function __invoke(CreateNewsRequest $request): Response
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
