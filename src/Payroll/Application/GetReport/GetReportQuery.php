<?php
declare(strict_types=1);

namespace App\Payroll\Application\GetReport;

use App\Common\Application\Query\Query;

final class GetReportQuery implements Query
{
    public function __construct(
        private string $reportId,
        private ?Sort $sort = null,
        private ?Filter $filter = null,
    ) {
    }

    public function getReportId(): string
    {
        return $this->reportId;
    }

    public function getSort(): ?Sort
    {
        return $this->sort;
    }

    public function getFilter(): ?Filter
    {
        return $this->filter;
    }
}
