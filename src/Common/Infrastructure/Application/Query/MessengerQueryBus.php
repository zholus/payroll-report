<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Application\Query;

use App\Common\Application\Query\Query;
use App\Common\Application\Query\QueryBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerQueryBus implements QueryBus
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function handle(Query $query): object
    {
        return $this->handleQuery($query);
    }
}
