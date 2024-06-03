<?php

declare(strict_types=1);

namespace App\Application\ReportGenerator;

interface ReportGeneratorInterface
{
    public function saveNewsInReport(array $arrayList): string;
}
