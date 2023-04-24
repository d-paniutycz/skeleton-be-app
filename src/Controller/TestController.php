<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
readonly class TestController
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
    ) {
    }

    #[Route(path: '/who-are-you')]
    public function test(): JsonResponse
    {
        return new JsonResponse([
            'app_env' => $this->parameterBag->get('app_env'),
            'app_name' => $this->parameterBag->get('app_name'),
            'app_release' => $this->parameterBag->get('app_release'),
        ]);
    }
}
