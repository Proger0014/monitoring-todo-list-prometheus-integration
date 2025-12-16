<?php

namespace App\Controller;

use App\DTO\CreateFolder;
use App\Repository\FolderRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/folders')]
final class FolderController extends AbstractController
{
    public function __construct(
        private readonly FolderRepository $folderRepository,
        private readonly TaskRepository $taskRepository,
    ) {
    }

    #[Route('', name: 'app_folder_get', methods: ['GET'], format: 'json')]
    public function getAll(): JsonResponse
    {
        $folders = $this->folderRepository->findAll();

        return $this->json($folders);
    }

    #[Route('', name: 'app_folder_create', methods: ['POST'], format: 'json')]
    public function createFolder(#[MapRequestPayload(acceptFormat: 'json')] CreateFolder $createFolder): JsonResponse
    {
        $folder = $this->folderRepository->createFolder($createFolder);

        return $this->json($folder);
    }

    #[Route('/{folder_id}/attach/{task_id}', name: 'app_folder_attach_task', methods: ['POST'], format: 'json')]
    public function attachTask(
        #[MapQueryParameter(name: 'folder_id')] int $folderId,
        #[MapQueryParameter(name: 'task_id')] int $taskId,
    ): JsonResponse {
        $folder = $this->folderRepository->findOneBy(['id' => $folderId]);
        $task = $this->taskRepository->findOneBy(['id' => $taskId]);

        $this->folderRepository->attachTask($folder, $task);

        return $this->json([
            'status' => 'success',
        ]);
    }
}
