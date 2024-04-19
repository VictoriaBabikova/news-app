<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

class CreateNewsReportResponse
{
    public function __construct
    (
        public readonly string $link
    )
    {}
}