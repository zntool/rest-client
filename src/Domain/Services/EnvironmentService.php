<?php

namespace ZnTool\RestClient\Domain\Services;

use ZnTool\RestClient\Domain\Interfaces\Services\EnvironmentServiceInterface;
use ZnTool\RestClient\Domain\Interfaces\Repositories\EnvironmentRepositoryInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Libs\Query;

class EnvironmentService extends BaseCrudService implements EnvironmentServiceInterface
{

    public function __construct(EnvironmentRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }

    public function allByProjectId(int $projectId, Query $query = null) {
        $query = Query::forge($query);
        $query->where('project_id', $projectId);
        return $this->all($query);
    }
}
