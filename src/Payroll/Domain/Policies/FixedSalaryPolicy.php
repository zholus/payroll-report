<?php
declare(strict_types=1);

namespace App\Payroll\Domain\Policies;

use App\Payroll\Domain\Employee;
use Money\Money;

final class FixedSalaryPolicy implements SalaryPolicy
{
    private const MAX_WORKED_YEARS_FOR_BONUS = 10;

    public function calculateSupplementSalary(Employee $employee): Money
    {
        $workedYears = $employee->workedYears();

        $salarySupplementValue = $employee->getDepartment()->getAdditionalSalary()->getNormalizedValue();

        if ($workedYears > self::MAX_WORKED_YEARS_FOR_BONUS) {
            return Money::USD($salarySupplementValue * self::MAX_WORKED_YEARS_FOR_BONUS);
        }

        return Money::USD($salarySupplementValue * $workedYears);
    }
}
