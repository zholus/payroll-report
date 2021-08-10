<?php
declare(strict_types=1);

namespace App\Payroll\Application\GenerateReport;

use App\Common\Application\Command\CommandHandler;
use App\Payroll\Domain\EmployeeRepository;
use App\Payroll\Domain\Report\Report;
use App\Payroll\Domain\Report\ReportId;
use App\Payroll\Domain\Report\ReportRepository;

final class GenerateReportHandler implements CommandHandler
{
    public function __construct(
        private EmployeeRepository $employeeRepository,
        private ReportRepository $reportRepository
    ) {
    }

    public function __invoke(GenerateReportCommand $command): void
    {
        $records = [];
        foreach ($this->employeeRepository->findAll() as $employee) {
            $records[] = $employee->createEmployeeRecord();
        }

        $this->reportRepository->save(
            Report::create(new ReportId($command->getReportId()), $records)
        );
    }
}
