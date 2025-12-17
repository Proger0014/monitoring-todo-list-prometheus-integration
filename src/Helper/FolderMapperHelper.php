<?php

namespace App\Helper;

use App\DTO\FolderDto;
use App\Entity\Folder;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\ObjectMapper\ObjectMapper;

#[Autoconfigure]
readonly class FolderMapperHelper
{
    public function __construct(private ObjectMapper $objectMapper)
    {
    }

    public function mapEntityToDto(Folder $folder): FolderDto
    {
        return $this->objectMapper->map($folder, FolderDto::class);
    }

    /**
     * @param list<Folder> $folders
     *
     * @return list<FolderDto>
     */
    public function mapEntityListToDtoList(array $folders): array
    {
        return array_map([$this, 'mapEntityToDto'], $folders);
    }
}
