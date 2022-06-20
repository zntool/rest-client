<?php

namespace ZnTool\RestClient\Domain\Services;

use Illuminate\Support\Collection;
use ZnCore\Base\Libs\Service\Base\BaseCrudService;
use ZnTool\RestClient\Domain\Entities\AuthorizationEntity;
use ZnTool\RestClient\Domain\Interfaces\Repositories\AuthorizationRepositoryInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\AuthorizationServiceInterface;

class AuthorizationService extends BaseCrudService implements AuthorizationServiceInterface
{

    public function __construct(AuthorizationRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }

    public function allByProjectId(int $projectId, string $type = null): Collection
    {
        return $this->getRepository()->allByProjectId($projectId, $type);
    }

    public function oneByUsername(int $projectId, string $username, string $type = null): AuthorizationEntity
    {
        return $this->getRepository()->oneByUsername($projectId, $username, $type);
    }

}
