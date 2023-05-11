<?php

declare(strict_types=1);

namespace App\Client\Application\Handler\Even;

use App\Client\Port\Api\Message\Event\ClientCreatedMessage;
use Sys\Application\Messenger\Handler\EventHandler;

class ClientCreatedHandler implements EventHandler
{
    public function __construct(
    ) {
    }

    public function __invoke(ClientCreatedMessage $message): void
    {
    }
}
