<?php

namespace ZnTool\RestClient\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
use ZnCore\Domain\Libs\Query;
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

    public function oneByTie(int $projectId, int $userId): AccessEntity
    {
        $query = new Query;
        $query->where('project_id', $projectId);
        $query->where('user_id', $userId);
        return $this->one($query);
    }

    public function allByUserId(int $userId): Collection
    {
        $query = new Query;
        $query->where('user_id', $userId);
        return $this->all($query);
    }

}
