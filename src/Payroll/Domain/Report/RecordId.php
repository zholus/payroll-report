<?php
declare(strict_types=1);

namespace App\Payroll\Domain\Report;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class RecordId
{
    private string $uuid;

    public function __construct(string $uuid)
    {
        if (!Uuid::isValid($uuid)) {
            throw new InvalidArgumentException(sprintf('Given UUID [%s] is invalid', $uuid));
        }

        $this->uuid = $uuid;
    }

    public static function create(): RecordId
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function getId(): string
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->getId();
    }
}
