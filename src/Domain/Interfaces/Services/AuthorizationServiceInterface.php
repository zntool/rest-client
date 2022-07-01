<?php

namespace ZnTool\RestClient\Domain\Interfaces\Services;

use Illuminate\Support\Collection;
use ZnCore\Domain\Service\Interfaces\CrudServiceInterface;
use ZnCore\Domain\Entity\Exceptions\NotFoundException;
use ZnTool\RestClient\Domain\Entities\AuthorizationEntity;

interface AuthorizationServiceInterface extends CrudServiceInterface
{

    /**
     * @param int $projectId
     * @param string|null $type
     * @return Collection
     */
    public function allByProjectId(int $projectId, string $type = null): Collection;

    /**
     * @param int $projectId
     * @param string $username
     * @param string|null $type
     * @return AuthorizationEntity
     * @throws NotFoundException
     */
    public function findOneByUsername(int $projectId, string $username, string $type = null): AuthorizationEntity;

}
