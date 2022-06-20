<?php

namespace ZnTool\RestClient\Domain\Interfaces\Repositories;

use Illuminate\Support\Collection;
use ZnCore\Base\Libs\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnTool\RestClient\Domain\Entities\BookmarkEntity;

interface BookmarkRepositoryInterface extends CrudRepositoryInterface
{

    public function removeByHash(string $hash): void;

    /**
     * @param string $hash
     * @return BookmarkEntity
     * @throws NotFoundException
     */
    public function oneByHash(string $hash): BookmarkEntity;

    public function allFavoriteByProject(int $projectId): Collection;

    public function allHistoryByProject(int $projectId): Collection;

    public function clearHistory(int $projectId): void;
}

