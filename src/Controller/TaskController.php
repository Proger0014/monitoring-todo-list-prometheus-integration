<?php

namespace App\Controller;

use App\DTO\CreateTask;
use App\Helper\TaskMapperHelper;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/tasks')]
final class TaskController extends AbstractController
{
    public function __construct(
        private readonly TaskRepository $taskRepository,
        private readonly TaskMapperHelper $mapper,
    ) {
    }

    #[Route('', name: 'app_task_get', methods: ['GET'], format: 'json')]
    public function getAll(): JsonResponse
    {
        $tasks = $this->taskRepository->findAll();

        $tasksDto = $this->mapper->mapEntityListToListTaskDto($tasks);

        return $this->json($tasksDto);
    }

    #[Route('', name: 'app_task_create', methods: ['POST'], format: 'json')]
    public function createTask(#[MapRequestPayload(acceptFormat: 'json')] CreateTask $createTask): JsonResponse
    {
        $createdTask = $this->taskRepository->createTask($createTask);

        $taskDto = $this->mapper->mapToTaskDto($createdTask);

        return $this->json($taskDto);
    }
}
