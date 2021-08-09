<?php
declare(strict_types=1);

namespace App\Payroll\Domain;

class AdditionalSalary
{
    public function __construct(private AdditionalSalaryType $type, private int $value)
    {
    }

    public function getType(): AdditionalSalaryType
    {
        return $this->type;
    }

    public function getNormalizedValue(): string
    {
        if ($this->type->equals(AdditionalSalaryType::PERCENTAGE())) {
            return (string)($this->value / 10000);
        }

        return (string) $this->value;
    }
}
