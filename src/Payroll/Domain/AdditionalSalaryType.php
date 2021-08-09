<?php
declare(strict_types=1);

namespace App\Payroll\Domain;

use MyCLabs\Enum\Enum;

/**
 * @method static AdditionalSalaryType FIXED()
 * @method static AdditionalSalaryType PERCENTAGE()
 */
final class AdditionalSalaryType extends Enum
{
    private const FIXED = 'fixed';
    private const PERCENTAGE = 'percentage';
}
