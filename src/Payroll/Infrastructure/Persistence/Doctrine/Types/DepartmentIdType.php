<?php
declare(strict_types=1);

namespace App\Payroll\Infrastructure\Persistence\Doctrine\Types;

use App\Payroll\Domain\DepartmentId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

final class DepartmentIdType extends GuidType
{
    private const NAME = 'DepartmentIdType';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new DepartmentId($value);
    }

    /**
     * @param DepartmentId $value
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
