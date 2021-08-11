<?php
declare(strict_types=1);

namespace App\Payroll\Application\GetReport;

class Filter
{
    public function __construct(private string $field, private string $value)
    {
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
