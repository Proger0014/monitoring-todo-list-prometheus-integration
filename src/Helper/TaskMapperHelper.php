<?php

namespace App\Helper;

use App\DTO\FolderDto;
use App\DTO\StatusDto;
use App\DTO\TaskDto;
use App\Entity\Task;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\ObjectMapper\ObjectMapper;

#[Autoconfigure]
readonly class TaskMapperHelper
{
    public function __construct(
        private ObjectMapper $objectMapper)
    {
    }

    public function mapToTaskDto(Task $task): TaskDto
    {
        $taskDto = $this->objectMapper->map($task, TaskDto::class);

        if ($task->getFolder()) {
            $taskDto->folder = $this->objectMapper->map($task->getFolder(), FolderDto::class);
        }

        $taskDto->status = $this->objectMapper->map($task->getStatus(), StatusDto::class);

        return $taskDto;
    }
}
