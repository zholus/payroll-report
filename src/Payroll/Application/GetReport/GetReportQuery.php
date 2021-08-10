<?php
declare(strict_types=1);

namespace App\Payroll\Application\GetReport;

use App\Common\Application\Query\Query;

final class GetReportQuery implements Query
{
    public function __construct(private string $reportId)
    {
    }

    public function getReportId(): string
    {
        return $this->reportId;
    }
}
