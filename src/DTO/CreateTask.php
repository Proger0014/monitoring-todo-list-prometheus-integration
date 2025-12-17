<?php

namespace App\DTO;

class CreateTask
{
    public string $title;
    public ?string $description = null;
    public int $statusId;
}
