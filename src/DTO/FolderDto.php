<?php

namespace App\DTO;

class FolderDto
{
    public int $id;
    public string $title;
    public ?string $description = null;
}
