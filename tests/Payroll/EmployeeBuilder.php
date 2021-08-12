<?php
declare(strict_types=1);

namespace App\Tests\Payroll;

use App\Payroll\Domain\Department;
use App\Payroll\Domain\Employee;
use App\Payroll\Domain\EmployeeId;
use DateTimeImmutable;
use Money\Money;
use Ramsey\Uuid\Uuid;

class EmployeeBuilder
{
    private EmployeeId $id;
    private Department $department;
    private string $firstName;
    private string $lastName;
    private Money $salary;
    private DateTimeImmutable $employedAt;

    public function __construct()
    {
        $this->id = new EmployeeId(Uuid::uuid4()->toString());
        $this->department = DepartmentBuilder::create()->build();
        $this->firstName = 'John';
        $this->lastName = 'Wick';
        $this->salary = Money::USD(1);
        $this->employedAt = new DateTimeImmutable();
    }

    public static function create(): self
    {
        return new self();
    }

    public function withSalary(int $value): self
    {
        $this->salary = Money::USD($value);

        return $this;
    }

    public function withDepartment(Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function withEmployedAt(DateTimeImmutable $employedAt): self
    {
        $this->employedAt = $employedAt;

        return $this;
    }

    public function build(): Employee
    {
        return new Employee(
            $this->id,
            $this->department,
            $this->firstName,
            $this->lastName,
            $this->salary,
            $this->employedAt
        );
    }
}
