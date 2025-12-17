<?php

namespace App\Controller;

use App\DTO\CreateFolder;
use App\Helper\FolderMapperHelper;
use App\Repository\FolderRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/folders')]
final class FolderController extends AbstractController
{
    public function __construct(
        private readonly FolderRepository $folderRepository,
        private readonly TaskRepository $taskRepository,
        private readonly FolderMapperHelper $folderMapperHelper,
    ) {
    }

    #[Route('', name: 'app_folder_get', methods: ['GET'], format: 'json')]
    public function getAll(): JsonResponse
    {
        $folders = $this->folderRepository->findAll();

        $mappedFolders = $this->folderMapperHelper->mapEntityListToDtoList($folders);

        return $this->json($mappedFolders);
    }

    #[Route('', name: 'app_folder_create', methods: ['POST'], format: 'json')]
    public function createFolder(#[MapRequestPayload(acceptFormat: 'json')] CreateFolder $createFolder): JsonResponse
    {
        $folder = $this->folderRepository->createFolder($createFolder);

        return $this->json($folder);
    }

    #[Route('/{folderId}/attach/{taskId}', name: 'app_folder_attach_task', methods: ['POST'], format: 'json')]
    public function attachTask(
        int $folderId,
        int $taskId,
    ): JsonResponse {
        $folder = $this->folderRepository->findOneBy(['id' => $folderId]);
        $task = $this->taskRepository->findOneBy(['id' => $taskId]);

        $this->folderRepository->attachTask($folder, $task);

        return $this->json([
            'status' => 'success',
        ]);
    }
}
