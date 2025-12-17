<?php

namespace App\DTO;

use Symfony\Component\ObjectMapper\Attribute\Map;

class TaskDto
{
    public int $id;
    public string $title;
    public ?string $description = null;

    #[Map(if: false)]
    public StatusDto $status;

    #[Map(if: false)]
    public ?FolderDto $folder;
}
