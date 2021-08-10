<?php
declare(strict_types=1);

namespace App\Payroll\Domain\Report;

class ReportSnapshot
{
    public function __construct(
        private string $reportId,
    ) {
    }
}
