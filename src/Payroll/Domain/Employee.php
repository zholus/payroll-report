<?php
declare(strict_types=1);

namespace App\Payroll\Domain;

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
}
