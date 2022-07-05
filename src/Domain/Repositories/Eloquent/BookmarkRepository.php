<?php

namespace ZnTool\RestClient\Domain\Repositories\Eloquent;

use ZnCore\Domain\Collection\Interfaces\Enumerable;
use ZnCore\Domain\Query\Entities\Query;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnTool\RestClient\Domain\Entities\BookmarkEntity;
use ZnTool\RestClient\Domain\Enums\StatusEnum;
use ZnTool\RestClient\Domain\Interfaces\Repositories\BookmarkRepositoryInterface;

class BookmarkRepository extends BaseEloquentCrudRepository implements BookmarkRepositoryInterface
{

    protected $tableName = 'restclient_bookmark';

    public function getEntityClass(): string
    {
        return BookmarkEntity::class;
    }

    public function removeByHash(string $hash): void
    {
        $bookmarkEntity = $this->findOneByHash($hash);
        $this->deleteById($bookmarkEntity->getId());
    }

    public function findOneByHash(string $hash): BookmarkEntity
    {
        $query = new Query;
        $query->where('hash', $hash);
        return $this->findOne($query);
    }

    public function allFavoriteByProject(int $projectId): Enumerable
    {
        $query = new Query;
        $query->where('status', StatusEnum::FAVORITE);
        $query->where('project_id', $projectId);
        return $this->findAll($query);
    }

    public function allHistoryByProject(int $projectId): Enumerable
    {
        $query = new Query;
        $query->where('status', StatusEnum::HISTORY);
        $query->where('project_id', $projectId);
        return $this->findAll($query);
    }

    public function clearHistory(int $projectId): void
    {
        $this->deleteByCondition([
            'project_id' => $projectId,
            'status' => StatusEnum::HISTORY,
        ]);
    }

}

