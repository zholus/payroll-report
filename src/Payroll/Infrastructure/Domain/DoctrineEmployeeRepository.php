<?php
declare(strict_types=1);

namespace App\Payroll\Infrastructure\Domain;

use App\Payroll\Domain\Employee;
use App\Payroll\Domain\EmployeeRecord;
use App\Payroll\Domain\EmployeeRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineEmployeeRepository extends ServiceEntityRepository implements EmployeeRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function findAll(): array
    {
        return parent::findAll();
    }

    public function saveEmployeesRecords(EmployeeRecord ...$records): void
    {
        $connection = $this->getEntityManager()->getConnection();

        $connection->executeQuery('DELETE FROM employees_report_records');

        foreach ($records as $record) {
            $connection->insert('employees_report_records', [
                'id' => $record->getId()->getId(),
                'first_name' => $record->getFirstName(),
                'last_name' => $record->getLastName(),
                'department_name' => $record->getDepartmentName(),
                'basic_salary' => $record->getBasicSalary(),
                'additional_salary_type' => $record->getAdditionalSalaryType(),
                'additional_salary_value' => $record->getAdditionalSalaryValue(),
                'total_salary' => $record->getTotalSalary(),
            ]);
        }
    }
}
