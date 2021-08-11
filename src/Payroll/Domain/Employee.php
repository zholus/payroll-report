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

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
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

    public function getTotalSalary(): Money
    {
        return $this->getSalary()->add($this->getAdditionalSalary());
    }

    public function getAdditionalSalary(): Money
    {
        try {
            return SalaryPolicyFactory::create($this)->calculateSupplementSalary($this);
        } catch (UnsupportedAdditionalSalaryType) {
            return Money::USD(0);
        }
    }
}
