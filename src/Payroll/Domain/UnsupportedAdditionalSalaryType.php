<?php
declare(strict_types=1);

namespace App\Payroll\Domain;

use RuntimeException;

final class UnsupportedAdditionalSalaryType extends RuntimeException
{
    public static function create(AdditionalSalaryType $type): self
    {
        return new self(sprintf('[%s] is currently unsupported', $type->getValue()));
    }
}
