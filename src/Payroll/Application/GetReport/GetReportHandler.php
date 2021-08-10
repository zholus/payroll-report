<?php
declare(strict_types=1);

namespace App\Payroll\Application\GetReport;

use App\Common\Application\Query\QueryHandler;

final class GetReportHandler implements QueryHandler
{
    public function __construct(private ReportReadModel $reportReadModel)
    {
    }

    public function __invoke(GetReportQuery $query): Report
    {
        return $this->reportReadModel->findReport($query->getReportId());
    }
}
