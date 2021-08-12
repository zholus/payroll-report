<?php
declare(strict_types=1);

namespace App\Tests\Payroll\E2E;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class BaseTestCase extends KernelTestCase
{
    protected function loadEmployees(): void
    {
        $this->executeQueries('employees');
    }

    private function executeQueries(string $fileName): void
    {
        /** @var Connection $connection */
        $connection = self::getContainer()->get(Connection::class);

        $content = file_get_contents($this->getFixturesPath($fileName));

        foreach (array_filter(explode("\n", $content)) as $query) {
            $connection->executeQuery($query);
        }
    }

    private function getFixturesPath(string $fileName): string
    {
        return __DIR__ . '/../../fixtures/sql/' . $fileName . '.sql';
    }
}
