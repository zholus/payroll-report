<?php
declare(strict_types=1);

namespace App\Payroll\Domain\Policies;

use App\Payroll\Domain\AdditionalSalaryType;
use App\Payroll\Domain\Employee;

class SalaryPolicyFactory
{
    public static function create(Employee $employee): SalaryPolicy
    {
        $type = $employee->getDepartment()->getAdditionalSalary()->getType();

        if ($type->equals(AdditionalSalaryType::FIXED())) {
            return new FixedSalaryPolicy();
        }

        if ($type->equals(AdditionalSalaryType::PERCENTAGE())) {
            return new PercentageSalaryPolicy();
        }

        throw UnsupportedAdditionalSalaryType::create($type);
    }
}
