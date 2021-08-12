<?php
declare(strict_types=1);

namespace App\Tests\Payroll;

use App\Payroll\Domain\AdditionalSalary;
use App\Payroll\Domain\AdditionalSalaryType;
use App\Payroll\Domain\Department;
use App\Payroll\Domain\DepartmentId;
use Ramsey\Uuid\Uuid;

class DepartmentBuilder
{
    private DepartmentId $id;
    private string $name;
    private AdditionalSalary $additionalSalary;

    public function __construct()
    {
        $this->id = new DepartmentId(Uuid::uuid4()->toString());
        $this->name = 'IT';
        $this->additionalSalary = new AdditionalSalary(AdditionalSalaryType::PERCENTAGE(), 1000);
    }

    public static function create(): self
    {
        return new self();
    }

    public function withAdditionalSalary(AdditionalSalary $additionalSalary): self
    {
        $this->additionalSalary = $additionalSalary;

        return $this;
    }

    public function build(): Department
    {
        return new Department(
            $this->id,
            $this->name,
            $this->additionalSalary
        );
    }
}
