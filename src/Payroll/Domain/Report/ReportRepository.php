<?php
declare(strict_types=1);

namespace App\Payroll\Domain\Report;

interface ReportRepository
{
    public function save(Report $report): void;
}
