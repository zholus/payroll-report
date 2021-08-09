<?php
declare(strict_types=1);

namespace App\Payroll\UI\Cli;

use App\Common\Application\Command\CommandBus;
use App\Payroll\Application\GenerateReport\GenerateReportCommand;
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $this->commandBus->dispatch(new GenerateReportCommand());

        $io->success('Report has been generated! User command `payroll:report:show` to display table.');
        return self::SUCCESS;
    }
}
