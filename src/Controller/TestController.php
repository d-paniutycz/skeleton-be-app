<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class TestController
{
    #[Route(path: '/who-are-you')]
    public function test(): JsonResponse
    {
        return new JsonResponse([
            'project' => getenv('COMPOSE_PROJECT_NAME'),
            'release' => getenv('APP_RELEASE'),
            'environment' => getenv('APP_ENV'),
        ]);
    }
}
