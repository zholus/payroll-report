<?php
declare(strict_types=1);

namespace App\Payroll\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use App\Payroll\Domain\AdditionalSalaryType as VO;

final class AdditionalSalaryType extends StringType
{
    private const NAME = 'AdditionalSalaryType';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new VO($value);
    }

    /**
     * @param VO $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getValue();
    }

    public function getName()
    {
        return self::NAME;
    }
}
