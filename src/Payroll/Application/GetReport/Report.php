<?php
declare(strict_types=1);

namespace App\Payroll\Application\GetReport;

class Report
{
    private array $records;

    public function __construct(Record ...$records)
    {
        $this->records = $records;
    }

    public function getRecords(): array
    {
        return $this->records;
    }
}
