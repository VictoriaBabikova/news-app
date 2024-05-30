<?php

namespace App\Application\ReportGenerator;

interface ReportGeneratorInterface
{
    public function saveNewsInReport(array $arrayList): string;
}
