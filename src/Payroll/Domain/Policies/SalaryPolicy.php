<?php
declare(strict_types=1);

namespace App\Payroll\Domain\Policies;

use App\Payroll\Domain\Employee;
use Money\Money;

interface SalaryPolicy
{
    public function calculateSupplementSalary(Employee $employee): Money;
}
