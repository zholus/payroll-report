<?php
declare(strict_types=1);

namespace App\Tests\Payroll\Unit\Domain\Policies;

use App\Payroll\Domain\AdditionalSalary;
use App\Payroll\Domain\AdditionalSalaryType;
use App\Payroll\Domain\Policies\PercentageSalaryPolicy;
use App\Tests\Payroll\DepartmentBuilder;
use App\Tests\Payroll\EmployeeBuilder;
use Money\Money;
use PHPUnit\Framework\TestCase;

final class PercentageSalaryPolicyTest extends TestCase
{
    /**
     * @dataProvider percentageSet
     */
    public function testProperlyAdditionalSalary(int $percentageValue, int $basicSalary, int $expectedAdditionalSalary)
    {
        $policy = new PercentageSalaryPolicy();

        $department = DepartmentBuilder::create()
            ->withAdditionalSalary(new AdditionalSalary(AdditionalSalaryType::PERCENTAGE(), $percentageValue))
            ->build();

        $additionalSalary = $policy->calculateAdditionalSalary(
            EmployeeBuilder::create()
                ->withSalary($basicSalary)
                ->withDepartment($department)
                ->build()
        );

        $this->assertTrue(Money::USD($expectedAdditionalSalary)->equals($additionalSalary));
    }

    public function percentageSet(): array
    {
        return [
            [1100, 450000, 49500],
            [9950, 12300, 12239],
            [5000, 100000, 50000],
            [10000, 1000, 1000],
            [0, 1000, 0],
        ];
    }
}
