<?php
declare(strict_types=1);

namespace App\Payroll\UI\Cli;

use App\Common\Application\Query\QueryBus;
use App\Payroll\Application\GetReport\Filter;
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
    private const FILTER_FIELD = 'filter-field';
    private const FILTER_VALUE = 'filter-value';

    public function __construct(private QueryBus $queryBus)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Show payroll report by given ID');
        $this->addArgument(self::REPORT_ID, InputArgument::REQUIRED);
        $this->addOption(
            self::SORT_FIELD,
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Available fields: first_name, last_name, department_name, basic_salary, additional_salary_value, additional_salary_type, total_salary'
        );
        $this->addOption(
            self::SORT_DIRECTION,
            mode: InputOption::VALUE_OPTIONAL,
            description: 'asc or desc',
            default: 'asc'
        );
        $this->addOption(
            self::FILTER_FIELD,
            mode: InputOption::VALUE_OPTIONAL,
            description: 'Available fields: first_name, last_name, department_name'
        );
        $this->addOption(self::FILTER_VALUE, mode: InputOption::VALUE_OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $reportId = $input->getArgument(self::REPORT_ID);

        $sortField = $input->getOption(self::SORT_FIELD);
        if (null !== $sortField) {
            $sort = new Sort($sortField, $input->getOption(self::SORT_DIRECTION));
        }

        $filterField = $input->getOption(self::FILTER_FIELD);
        $filterValue = $input->getOption(self::FILTER_VALUE);
        if (null !== $filterField && null !== $filterValue) {
            $filter = new Filter($filterField, $filterValue);
        }

        /** @var Report $report */
        $report = $this->queryBus->handle(
            new GetReportQuery(
                $reportId,
                $sort ?? null,
                $filter ?? null
            )
        );

        if (empty($report->getRecords())) {
            $io->error('Report not found, try again with an empty filter');
            return self::FAILURE;
        }

        $presenter = new PayrollReportTablePresenter($report);

        $table = new Table($output);
        $table
            ->setHeaders($presenter->getHeaders())
            ->setRows($presenter->getRows())
            ->render();

        return self::SUCCESS;
    }
}
