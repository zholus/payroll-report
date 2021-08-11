<?php
declare(strict_types=1);

namespace App\Payroll\Application\GetReport;

interface ReportReadModel
{
    public function findReport(GetReportQuery $query): Report;
}
