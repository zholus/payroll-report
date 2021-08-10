<?php
declare(strict_types=1);

namespace App\Payroll\UI\Cli;

use App\Common\Application\Query\QueryBus;
use App\Payroll\Application\GetReport\GetReportQuery;
use App\Payroll\Application\GetReport\Report;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ShowPayrollReportCommand extends Command
{
    protected static $defaultName = 'payroll:report:show';

    public function __construct(private QueryBus $queryBus)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('report_id', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $reportId = $input->getArgument('report_id');

        /** @var Report $report */
        $report = $this->queryBus->handle(new GetReportQuery($reportId));

        if (empty($report->getRecords())) {
            $io->error('Report not found');
            return self::FAILURE;
        }

        $presenter = new PayrollReportTablePresenter($report);
        $table = new Table($output);
        $table
            ->setHeaders(['First name', 'Last name', 'Department', 'Basic salary', 'Additional salary', 'Additional salary type', 'Total salary'])
            ->setRows($presenter->present());
        $table->render();

        return self::SUCCESS;
    }
}
