<?php

declare(strict_types=1);

namespace App\Application\UseCase\Response;

class CreateListNewsResponse
{
    public function __construct
    (
        public readonly array $arrayList
    )
    {}
}
