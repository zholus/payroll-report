<?php
declare(strict_types=1);

namespace App\Payroll\Domain;

interface EmployeeRepository
{
    /**
     * @return Employee[]
     */
    public function findAll(): array;
    public function saveEmployeesRecords(EmployeeRecord ...$records): void;
}
