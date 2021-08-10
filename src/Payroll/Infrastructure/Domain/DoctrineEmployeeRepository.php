<?php
declare(strict_types=1);

namespace App\Payroll\Infrastructure\Domain;

use App\Payroll\Domain\Employee;
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
}
