<?php
declare(strict_types=1);

namespace App\Payroll\Application\GenerateReport;

use App\Common\Application\Command\CommandHandler;
use App\Payroll\Domain\EmployeeRepository;
use App\Payroll\Domain\Report\RecordFactory;
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
            $records[] = RecordFactory::fromEmployee($employee);
        }

        if (empty($records)) {
            throw new CannotGenerateReportException('Cannot generate an empty report');
        }

        $this->reportRepository->save(
            Report::create(new ReportId($command->getReportId()), $records)
        );
    }
}
