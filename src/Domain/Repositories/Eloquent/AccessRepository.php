<?php

namespace ZnTool\RestClient\Domain\Repositories\Eloquent;

use ZnCore\Collection\Interfaces\Enumerable;
use ZnCore\Domain\Query\Entities\Query;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnTool\RestClient\Domain\Entities\AccessEntity;
use ZnTool\RestClient\Domain\Interfaces\Repositories\AccessRepositoryInterface;

class AccessRepository extends BaseEloquentCrudRepository implements AccessRepositoryInterface
{

    protected $tableName = 'restclient_access';

    public function getEntityClass(): string
    {
        return AccessEntity::class;
    }

    public function findOneByTie(int $projectId, int $userId): AccessEntity
    {
        $query = new Query;
        $query->where('project_id', $projectId);
        $query->where('user_id', $userId);
        return $this->findOne($query);
    }

    public function allByUserId(int $userId): Enumerable
    {
        $query = new Query;
        $query->where('user_id', $userId);
        return $this->findAll($query);
    }

}
