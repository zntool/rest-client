<?php

namespace ZnTool\RestClient\Domain\Services;

use ZnTool\RestClient\Domain\Interfaces\Repositories\AccessRepositoryInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\AccessServiceInterface;
use ZnCore\Domain\Service\Base\BaseCrudService;

class AccessService extends BaseCrudService implements AccessServiceInterface
{

    public function __construct(AccessRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }

    public function attach($projectId, $userId) {
        $this->create([
            'projectId' => $projectId,
            'userId' => $userId,
        ]);
    }

    public function detach($projectId, $userId) {
        $this->getRepository()->deleteByCondition([
            'project_id' => $projectId,
            'user_id' => $userId,
        ]);
    }
}
