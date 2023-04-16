<?php

declare(strict_types=1);

namespace App\Client\Application\Handler\Query;

use App\Client\Application\Model\ClientTokenDto;
use App\Client\Application\Repository\ClientTokenReadRepository;
use App\Client\Domain\ClientToken;
use App\Client\Port\Api\Message\Query\ClientTokenReadMessage;
use Sys\Application\Exception\Entity\EntityNotFoundException;
use Sys\Application\Messenger\Handler\QueryHandler;

readonly class ClientTokenReadHandler implements QueryHandler
{
    public function __construct(
        private ClientTokenReadRepository $tokenReadRepository,
    ) {
    }

    public function __invoke(ClientTokenReadMessage $message): ClientTokenDto
    {
        return $this->tokenReadRepository->find($message->tokenValue)
            ?? throw new EntityNotFoundException(ClientToken::class, '<moderated>', 'value');
    }
}
