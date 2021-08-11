<?php
declare(strict_types=1);

namespace App\Payroll\Domain\Report;

use App\Payroll\Domain\Employee;

class RecordFactory
{
    public static function fromEmployee(Employee $employee): Record
    {
        return new Record(
            RecordId::create(),
            $employee->getFirstName(),
            $employee->getLastName(),
            $employee->getDepartment()->getName(),
            (int)$employee->getSalary()->getAmount(),
            (int)$employee->getAdditionalSalary()->getAmount(),
            $employee->getDepartment()->getAdditionalSalary()->getType()->getValue(),
            (int)$employee->getTotalSalary()->getAmount()
        );
    }
}
