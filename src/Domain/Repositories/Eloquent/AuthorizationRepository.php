<?php

namespace ZnTool\RestClient\Domain\Repositories\Eloquent;

use ZnCore\Domain\Collection\Libs\Collection;
use ZnCore\Domain\Query\Entities\Query;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnTool\RestClient\Domain\Entities\AuthorizationEntity;
use ZnTool\RestClient\Domain\Interfaces\Repositories\AuthorizationRepositoryInterface;

class AuthorizationRepository extends BaseEloquentCrudRepository implements AuthorizationRepositoryInterface
{

    protected $tableName = 'restclient_authorization';

    public function getEntityClass(): string
    {
        return AuthorizationEntity::class;
    }

    public function allByProjectId(int $projectId, string $type = null): Collection
    {
        $query = new Query;
        $query->where('project_id', $projectId);
        if ($type) {
            $query->where('type', 'bearer');
        }
        return $this->findAll($query);
    }

    public function findOneByUsername(int $projectId, string $username, string $type = null): AuthorizationEntity
    {
        $query = new Query;
        $query->where('project_id', $projectId);
        $query->where('type', 'bearer');
        $query->where('username', $username);
        return $this->findOne($query);
    }

}
