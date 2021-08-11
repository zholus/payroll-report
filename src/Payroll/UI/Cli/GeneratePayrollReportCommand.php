<?php
declare(strict_types=1);

namespace App\Payroll\UI\Cli;

use App\Common\Application\Command\CommandBus;
use App\Payroll\Application\GenerateReport\GenerateReportCommand;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class GeneratePayrollReportCommand extends Command
{
    protected static $defaultName = 'payroll:report:generate';

    public function __construct(private CommandBus $commandBus)
    {
        parent::__construct();
    }

    public function configure()
    {
        $this->setDescription('Generate new payroll report');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $reportId = Uuid::uuid4()->toString();

        $this->commandBus->dispatch(new GenerateReportCommand($reportId));

        $io->success(sprintf(
            'Report has been generated! User command `payroll:report:show %s` to display table.',
            $reportId
        ));
        return self::SUCCESS;
    }
}
