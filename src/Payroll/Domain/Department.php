<?php
declare(strict_types=1);

namespace App\Payroll\Domain;

class Department
{
    public function __construct(
        private DepartmentId $id,
        private string $name,
        private AdditionalSalary $additionalSalary
    ) {
    }

    public function getId(): DepartmentId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAdditionalSalary(): AdditionalSalary
    {
        return $this->additionalSalary;
    }
}
