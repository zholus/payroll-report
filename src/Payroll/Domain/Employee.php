<?php
declare(strict_types=1);

namespace App\Payroll\Domain;

use App\Payroll\Domain\Policies\SalaryPolicyFactory;
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

    public function createEmployeeRecord(): EmployeeRecord
    {
        return new EmployeeRecord(
            new RecordId($this->id->getId()),
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
        } catch (UnsupportedAdditionalSalaryType $e) {
            return Money::USD(0);
        }
    }
}
