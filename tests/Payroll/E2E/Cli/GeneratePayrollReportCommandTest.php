<?php
declare(strict_types=1);

namespace App\Tests\Payroll\E2E\Cli;

use App\Payroll\Application\GenerateReport\CannotGenerateReportException;
use App\Payroll\Application\GetReport\GetReportQuery;
use App\Payroll\Application\GetReport\ReportReadModel;
use App\Payroll\Domain\Report\ReportRepository;
use App\Tests\Payroll\E2E\BaseTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

final class GeneratePayrollReportCommandTest extends BaseTestCase
{
    private CommandTester $commandTester;

    public function setUp(): void
    {
        $kernel = static::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('payroll:report:generate');
        $this->commandTester = new CommandTester($command);
    }

    public function testReportHasNotBeenGenerated(): void
    {
        self::expectException(CannotGenerateReportException::class);

        $this->commandTester->execute([]);
    }

    public function testReportHasBeenGenerated(): void
    {
        $this->loadEmployees();

        $this->commandTester->execute([]);

        self::assertSame(Command::SUCCESS, $this->commandTester->getStatusCode());
    }
}
