<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class TestController
{
    public function __construct(
        private readonly ParameterBagInterface $parameterBag,
        private readonly ManagerRegistry $managerRegistry,
    ) {
    }

    private function ping(string $address): bool
    {
        exec("/bin/ping -c1 -w1 $address", $outcome, $status);

        return $status === 0 && !empty($outcome);
    }

    private function connect(string $connectionKey): bool
    {
        return $this->managerRegistry->getConnection($connectionKey)->connect();
    }

    #[Route(path: '/who-are-you')]
    public function test(): JsonResponse
    {
        return new JsonResponse([
            'app_env' => $this->parameterBag->get('app_env'),
            'app_name' => $this->parameterBag->get('app_name'),
            'app_release' => $this->parameterBag->get('app_release'),
            'dms-pg1_service_status' => $this->ping('pg1') ? "I'm okay" : "Need help!",
            'dms-pg1-pri_connection' => $this->connect('dms_pg1_pri'),
            'dms-pg1-rep_connection' => $this->connect('dms_pg1_rep'),
        ]);
    }
}
