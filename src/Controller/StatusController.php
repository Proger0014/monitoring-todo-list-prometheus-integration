<?php

namespace App\Controller;

use App\DTO\CreateStatus;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/statuses')]
final class StatusController extends AbstractController
{
    public function __construct(
        private StatusRepository $statusRepository,
    ) {
    }

    #[Route('', name: 'app_status_create', methods: ['POST'], format: 'json')]
    public function addStatus(#[MapRequestPayload(acceptFormat: 'json')] CreateStatus $createStatus): JsonResponse
    {
        $result = $this->statusRepository->createStatus($createStatus);

        return $this->json($result);
    }

    #[Route('', name: 'app_status_get', methods: ['GET'], format: 'json')]
    public function getStatuses(): JsonResponse
    {
        $result = $this->statusRepository->findAll();

        return $this->json($result);
    }
}
