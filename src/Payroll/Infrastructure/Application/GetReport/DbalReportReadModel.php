<?php
declare(strict_types=1);

namespace App\Payroll\Infrastructure\Application\GetReport;

use App\Payroll\Application\GetReport\GetReportQuery;
use App\Payroll\Application\GetReport\Record;
use App\Payroll\Application\GetReport\Report;
use App\Payroll\Application\GetReport\ReportReadModel;
use Doctrine\DBAL\Connection;

final class DbalReportReadModel implements ReportReadModel
{
    private const ALLOWED_SORT = [
        'first_name',
        'last_name',
        'department_name',
        'basic_salary',
        'additional_salary_value',
        'additional_salary_type',
        'total_salary',
    ];

    public function __construct(private Connection $connection)
    {
    }

    public function findReport(GetReportQuery $query): Report
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->select(
            'first_name',
            'last_name',
            'department_name',
            'basic_salary',
            'additional_salary_value',
            'additional_salary_type',
            'total_salary',
        )
            ->from('payroll_report_records')
            ->where('report_id = :REPORT_ID')
            ->setParameter('REPORT_ID', $query->getReportId())
        ;

        if ($query->getSort() !== null &&
            in_array($query->getSort()->getField(), self::ALLOWED_SORT, true)
        ) {
            $qb->orderBy($query->getSort()->getField(), $query->getSort()->getDirection());
        }

        $result = $qb->execute();

        $records = [];
        foreach ($result->fetchAllAssociative() as $row) {
            $records[] = new Record(
                $row['first_name'],
                $row['last_name'],
                $row['department_name'],
                (int)$row['basic_salary'],
                (int)$row['additional_salary_value'],
                $row['additional_salary_type'],
                (int)$row['total_salary'],
            );
        }

        return new Report(...$records);
    }
}
