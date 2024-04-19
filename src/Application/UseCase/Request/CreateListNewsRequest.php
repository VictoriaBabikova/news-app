<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

class CreateListNewsRequest
{
    public function __construct
    (
        public readonly array $arrayList = []
    )
    {}
}
