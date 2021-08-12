<?php
declare(strict_types=1);

namespace App\Tests\Payroll\Unit\Domain\Policies;

use App\Payroll\Domain\AdditionalSalary;
use App\Payroll\Domain\AdditionalSalaryType;
use App\Payroll\Domain\Policies\FixedSalaryPolicy;
use App\Tests\Payroll\DepartmentBuilder;
use App\Tests\Payroll\EmployeeBuilder;
use DateInterval;
use DateTimeImmutable;
use Money\Money;
use PHPUnit\Framework\TestCase;

final class FixedSalaryPolicyTest extends TestCase
{
    /**
     * @dataProvider fixedSalarySet
     */
    public function testAdditionalSalaryBasedOnEmployedDate(
        int $fixedValue, int $basicSalary, int $workedYears, int $expectedAdditionalSalary
    ): void {
        $policy = new FixedSalaryPolicy();

        $department = DepartmentBuilder::create()
            ->withAdditionalSalary(new AdditionalSalary(AdditionalSalaryType::FIXED(), $fixedValue))
            ->build();

        $additionalSalary = $policy->calculateAdditionalSalary(
            EmployeeBuilder::create()
                ->withSalary($basicSalary)
                ->withDepartment($department)
                ->withEmployedAt((new DateTimeImmutable())->sub(new DateInterval(sprintf('P%dY1D', $workedYears))))
                ->build()
        );

        $this->assertTrue(Money::USD($expectedAdditionalSalary)->equals($additionalSalary));
    }

    public function fixedSalarySet(): array
    {
        return [
            [17500, 100000, 28, 175000],
            [17500, 100000, 11, 175000],
            [17500, 100000, 10, 175000],
            [17500, 100000, 9, 157500],
            [17500, 100000, 1, 17500],
            [17500, 100000, 3, 52500],
            [17500, 100000, 0, 0],
        ];
    }
}
