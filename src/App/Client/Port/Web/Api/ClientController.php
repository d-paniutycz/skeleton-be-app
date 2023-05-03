<?php

declare(strict_types=1);

namespace App\Client\Port\Web\Api;

use App\Client\Application\Input\ClientCreateInput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sys\Application\Exception\InvalidStringValueException;
use Sys\Infrastructure\Port\Web\AbstractWebController;

#[Route(path: '/api/v1/client')]
final class ClientController extends AbstractWebController
{
    #[Route(path: null, methods: Request::METHOD_POST)]
    public function create(ClientCreateInput $createInput): JsonResponse
    {
        throw new InvalidStringValueException('Invalid ULID identifier', '2ASE353GXQAZ');

        return new JsonResponse($createInput);
    }
}
