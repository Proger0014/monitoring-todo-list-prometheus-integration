<?php

namespace App\Helper;

use App\DTO\StatusDto;
use App\Entity\Status;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\ObjectMapper\ObjectMapper;

#[Autoconfigure]
class StatusMapperHelper
{
    public function __construct(private readonly ObjectMapper $objectMapper)
    {
    }

    public function mapEntityToDto(Status $status): StatusDto
    {
        return $this->objectMapper->map($status, StatusDto::class);
    }

    /**
     * @param list<Status> $statuses
     *
     * @return list<StatusDto>
     */
    public function mapEntityListToDtoList(array $statuses): array
    {
        return array_map([$this, 'mapEntityToDto'], $statuses);
    }
}
