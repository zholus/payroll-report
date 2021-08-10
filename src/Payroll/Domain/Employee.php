<?php
declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Payroll\Domain\Policies\SalaryPolicyFactory;
use App\Payroll\Domain\Report\Record;
use App\Payroll\Domain\Report\RecordId;
use DateTimeImmutable;
use Money\Money;

class Employee
{
    private function __construct(
        private EmployeeId $id,
        private Department $department,
        private string $firstName,
        private string $lastName,
        private Money $salary,
        private DateTimeImmutable $employedAt
    ) {
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function getSalary(): Money
    {
        return $this->salary;
    }

    public function workedYears(): int
    {
        return (new DateTimeImmutable())->diff($this->employedAt)->y;
    }

    public function createEmployeeRecord(): Record
    {
        return new Record(
            RecordId::create(),
            $this->firstName,
            $this->lastName,
            $this->department->getName(),
            (int)$this->salary->getAmount(),
            (int)$this->getAdditionalSalary()->getAmount(),
            $this->department->getAdditionalSalary()->getType()->getValue(),
            (int)$this->salary->add($this->getAdditionalSalary())->getAmount()
        );
    }

    private function getAdditionalSalary(): Money
    {
        try {
            return SalaryPolicyFactory::create($this)->calculateSupplementSalary($this);
        } catch (UnsupportedAdditionalSalaryType) {
            return Money::USD(0);
        }
    }
}
