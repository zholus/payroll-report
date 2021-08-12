<?php
declare(strict_types=1);

namespace App\Payroll\Domain\Policies;

use App\Payroll\Domain\Employee;
use Money\Money;

final class FixedSalaryPolicy implements SalaryPolicy
{
    private const MAX_WORKED_YEARS_FOR_BONUS = 10;

    public function calculateAdditionalSalary(Employee $employee): Money
    {
        $workedYears = $employee->workedYears();

        $additionalSalaryValue = $employee->getDepartment()->getAdditionalSalary()->getNormalizedValue();

        if ($workedYears > self::MAX_WORKED_YEARS_FOR_BONUS) {
            return Money::USD($additionalSalaryValue * self::MAX_WORKED_YEARS_FOR_BONUS);
        }

        return Money::USD($additionalSalaryValue * $workedYears);
    }
}
