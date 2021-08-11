<?php
declare(strict_types=1);

namespace App\Payroll\UI\Cli;

use App\Payroll\Application\GetReport\Report;

class PayrollReportTablePresenter
{
    public function __construct(private Report $report)
    {
    }

    public function getHeaders(): array
    {
        return [
            'First name',
            'Last name',
            'Department',
            'Basic salary',
            'Additional salary',
            'Additional salary type',
            'Total salary'
        ];
    }

    public function getRows(): array
    {
        $tableRows = [];
        foreach ($this->report->getRecords() as $record) {
            $tableRows[] = [
                $record->getFirstName(),
                $record->getLastName(),
                $record->getDepartmentName(),
                $this->formatNumbers($record->getBasicSalary()),
                $this->formatNumbers($record->getAdditionalSalaryValue()),
                $record->getAdditionalSalaryType(),
                $this->formatNumbers($record->getTotalSalary()),
            ];
        }

        return $tableRows;
    }

    private function formatNumbers(int $value): string
    {
        return '$' . number_format(($value / 100), 2);
    }
}
