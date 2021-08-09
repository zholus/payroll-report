<?php
declare(strict_types=1);

namespace App\Payroll\Application\GenerateReport;

use App\Common\Application\Command\CommandHandler;

final class GenerateReportHandler implements CommandHandler
{
    public function __invoke(GenerateReportCommand $command): void
    {
        // todo:
    }
}
