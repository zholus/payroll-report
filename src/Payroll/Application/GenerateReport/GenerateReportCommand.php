<?php
declare(strict_types=1);

namespace App\Payroll\Application\GenerateReport;

use App\Common\Application\Command\Command;

final class GenerateReportCommand implements Command
{
    public function __construct(private string $reportId)
    {
    }

    public function getReportId(): string
    {
        return $this->reportId;
    }
}
