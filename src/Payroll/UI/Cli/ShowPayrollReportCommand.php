<?php
declare(strict_types=1);

namespace App\Payroll\UI\Cli;

use App\Common\Application\Query\QueryBus;
use App\Payroll\Application\GetReport\GetReportQuery;
use App\Payroll\Application\GetReport\Report;
use App\Payroll\Application\GetReport\Sort;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ShowPayrollReportCommand extends Command
{
    protected static $defaultName = 'payroll:report:show';

    private const REPORT_ID = 'report_id';
    private const SORT_FIELD = 'sort-field';
    private const SORT_DIRECTION = 'sort-direction';

    public function __construct(private QueryBus $queryBus)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument(self::REPORT_ID, InputArgument::REQUIRED);
        $this->addOption(self::SORT_FIELD, mode: InputOption::VALUE_OPTIONAL);
        $this->addOption(self::SORT_DIRECTION, mode: InputOption::VALUE_OPTIONAL, default: 'asc');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $reportId = $input->getArgument(self::REPORT_ID);

        if ($input->hasOption(self::SORT_FIELD)) {
            $sort = new Sort($input->getOption(self::SORT_FIELD), $input->getOption(self::SORT_DIRECTION));
        }

        /** @var Report $report */
        $report = $this->queryBus->handle(
            new GetReportQuery(
                $reportId,
                $sort ?? null
            )
        );

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
