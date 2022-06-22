<?php

namespace ZnTool\RestClient\Domain\Repositories\Eloquent;

use Illuminate\Support\Collection;
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
        $bookmarkEntity = $this->oneByHash($hash);
        $this->deleteById($bookmarkEntity->getId());
    }

    public function oneByHash(string $hash): BookmarkEntity
    {
        $query = new Query;
        $query->where('hash', $hash);
        return $this->one($query);
    }

    public function allFavoriteByProject(int $projectId): Collection
    {
        $query = new Query;
        $query->where('status', StatusEnum::FAVORITE);
        $query->where('project_id', $projectId);
        return $this->all($query);
    }

    public function allHistoryByProject(int $projectId): Collection
    {
        $query = new Query;
        $query->where('status', StatusEnum::HISTORY);
        $query->where('project_id', $projectId);
        return $this->all($query);
    }

    public function clearHistory(int $projectId): void
    {
        $this->deleteByCondition([
            'project_id' => $projectId,
            'status' => StatusEnum::HISTORY,
        ]);
    }

}

