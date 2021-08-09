<?php
declare(strict_types=1);

namespace App\Payroll\Infrastructure\Persistence\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use App\Payroll\Domain\EmployeeId;

final class EmployeeIdType extends GuidType
{
    private const NAME = 'EmployeeIdType';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new EmployeeId($value);
    }

    /**
     * @param EmployeeId $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->getId();
    }

    public function getName()
    {
        return self::NAME;
    }
}
