<?php
declare(strict_types=1);

namespace App\Payroll\Application\GetReport;

use InvalidArgumentException;

class Sort
{
    private const ALLOWED_DIRECTIONS = ['asc', 'desc'];
    private string $field;
    private string $direction;

    public function __construct(string $field, string $direction)
    {
        $field = strtolower($field);
        $direction = strtolower($direction);

        if (!in_array($direction, self::ALLOWED_DIRECTIONS, true)) {
            throw new InvalidArgumentException('Sort direction must be only ASC or DESC');
        }

        $this->direction = $direction;
        $this->field = $field;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }
}
