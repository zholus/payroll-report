<?php
declare(strict_types=1);

namespace App\Payroll\Domain\Policies;

use App\Payroll\Domain\Employee;
use Money\Money;

final class PercentageSalaryPolicy implements SalaryPolicy
{
    public function calculateSupplementSalary(Employee $employee): Money
    {
        return $employee->getSalary()->multiply(
            $employee->getDepartment()->getAdditionalSalary()->getNormalizedValue()
        );
    }
}
