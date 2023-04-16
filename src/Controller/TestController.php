<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class TestController
{
    #[Route(path: '/test')]
    public function test(): JsonResponse
    {
        return new JsonResponse('ok');
    }
}
