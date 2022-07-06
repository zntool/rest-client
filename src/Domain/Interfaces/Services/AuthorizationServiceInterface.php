<?php

namespace ZnTool\RestClient\Domain\Interfaces\Services;

use ZnCore\Collection\Interfaces\Enumerable;
use ZnCore\Entity\Exceptions\NotFoundException;
use ZnCore\Domain\Service\Interfaces\CrudServiceInterface;
use ZnTool\RestClient\Domain\Entities\AuthorizationEntity;

interface AuthorizationServiceInterface extends CrudServiceInterface
{

    /**
     * @param int $projectId
     * @param string|null $type
     * @return Enumerable
     */
    public function allByProjectId(int $projectId, string $type = null): Enumerable;

    /**
     * @param int $projectId
     * @param string $username
     * @param string|null $type
     * @return AuthorizationEntity
     * @throws NotFoundException
     */
    public function findOneByUsername(int $projectId, string $username, string $type = null): AuthorizationEntity;

}
