<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class CreateNewsReportRequest
{
    public function __construct
    (
        public readonly string $ids_list
    )
    {}
}
