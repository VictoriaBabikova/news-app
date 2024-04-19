<?php

namespace App\Domain\Repository;

use App\Domain\Entity\News;

interface NewsRepositoryInterface
{
    public function save(News $news): void;

    public function findNewsByArrayOfId(array $arrayId): ?array;

    public function saveNewsInReport(array $arrayList): string;
}
