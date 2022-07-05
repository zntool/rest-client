<?php

namespace ZnTool\RestClient\Domain\Services;

use ZnCore\Domain\Collection\Interfaces\Enumerable;
use ZnCore\Domain\Collection\Libs\Collection;
use ZnCore\Domain\Service\Base\BaseCrudService;
use ZnTool\RestClient\Domain\Entities\AuthorizationEntity;
use ZnTool\RestClient\Domain\Interfaces\Repositories\AuthorizationRepositoryInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\AuthorizationServiceInterface;

class AuthorizationService extends BaseCrudService implements AuthorizationServiceInterface
{

    public function __construct(AuthorizationRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }

    public function allByProjectId(int $projectId, string $type = null): Enumerable
    {
        return $this->getRepository()->allByProjectId($projectId, $type);
    }

    public function findOneByUsername(int $projectId, string $username, string $type = null): AuthorizationEntity
    {
        return $this->getRepository()->findOneByUsername($projectId, $username, $type);
    }

}
