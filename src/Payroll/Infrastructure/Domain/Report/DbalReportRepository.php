<?php
declare(strict_types=1);

namespace App\Payroll\Infrastructure\Domain\Report;

use App\Payroll\Domain\Report\Report;
use App\Payroll\Domain\Report\ReportRepository;
use Doctrine\DBAL\Connection;

final class DbalReportRepository implements ReportRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function save(Report $report): void
    {
        $this->connection->insert('payroll_report', [
            'id' => $report->getId()->getId()
        ]);

        foreach ($report->getRecords() as $record) {
            $this->connection->insert('payroll_report_records', [
                'id' => $record->getId()->getId(),
                'report_id' => $report->getId()->getId(),
                'first_name' => $record->getFirstName(),
                'last_name' => $record->getLastName(),
                'department_name' => $record->getDepartmentName(),
                'basic_salary' => $record->getBasicSalary(),
                'additional_salary_type' => $record->getAdditionalSalaryType(),
                'additional_salary_value' => $record->getAdditionalSalaryValue(),
                'total_salary' => $record->getTotalSalary(),
            ]);
        }
    }
}
