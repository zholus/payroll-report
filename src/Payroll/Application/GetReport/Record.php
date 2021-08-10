<?php
declare(strict_types=1);

namespace App\Payroll\Application\GetReport;

final class Record
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $departmentName,
        private int $basicSalary,
        private int $additionalSalaryValue,
        private string $additionalSalaryType,
        private int $totalSalary,
    ) {
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getDepartmentName(): string
    {
        return $this->departmentName;
    }

    public function getBasicSalary(): int
    {
        return $this->basicSalary;
    }

    public function getAdditionalSalaryValue(): int
    {
        return $this->additionalSalaryValue;
    }

    public function getAdditionalSalaryType(): string
    {
        return $this->additionalSalaryType;
    }

    public function getTotalSalary(): int
    {
        return $this->totalSalary;
    }
}
