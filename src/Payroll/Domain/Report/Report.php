<?php
declare(strict_types=1);

namespace App\Payroll\Domain\Report;

class Report
{
    /**
     * @param Record[] $records
     */
    private function __construct(
        private ReportId $id,
        private array $records
    ) {
    }

    /**
     * @param Record[] $records
     */
    public static function create(
        ReportId $id,
        array $records
    ): self {
        return new self($id, $records);
    }

    public function getId(): ReportId
    {
        return $this->id;
    }

    /**
     * @return Record[]
     */
    public function getRecords(): array
    {
        return $this->records;
    }
}
