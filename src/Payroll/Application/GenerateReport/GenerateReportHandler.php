<?php
declare(strict_types=1);

namespace App\Payroll\Application\GenerateReport;

use App\Common\Application\Command\CommandHandler;
use App\Payroll\Domain\EmployeeRepository;

final class GenerateReportHandler implements CommandHandler
{
    public function __construct(private EmployeeRepository $employeeRepository)
    {
    }

    public function __invoke(GenerateReportCommand $command): void
    {
        $records = [];
        foreach ($this->employeeRepository->findAll() as $employee) {
            $records[] = $employee->createEmployeeRecord();
        }

        $this->employeeRepository->saveEmployeesRecords(...$records);
    }
}
