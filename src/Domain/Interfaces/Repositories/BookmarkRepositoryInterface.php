<?php

namespace ZnTool\RestClient\Domain\Interfaces\Repositories;

use ZnCore\Domain\Collection\Libs\Collection;
use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Domain\Entity\Exceptions\NotFoundException;
use ZnTool\RestClient\Domain\Entities\BookmarkEntity;

interface BookmarkRepositoryInterface extends CrudRepositoryInterface
{

    public function removeByHash(string $hash): void;

    /**
     * @param string $hash
     * @return BookmarkEntity
     * @throws NotFoundException
     */
    public function findOneByHash(string $hash): BookmarkEntity;

    public function allFavoriteByProject(int $projectId): Collection;

    public function allHistoryByProject(int $projectId): Collection;

    public function clearHistory(int $projectId): void;
}

