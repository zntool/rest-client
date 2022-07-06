<?php

namespace ZnTool\RestClient\Domain\Interfaces\Repositories;

use ZnCore\Collection\Interfaces\Enumerable;
use ZnCore\Entity\Exceptions\NotFoundException;
use ZnCore\Repository\Interfaces\CrudRepositoryInterface;
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

    public function allFavoriteByProject(int $projectId): Enumerable;

    public function allHistoryByProject(int $projectId): Enumerable;

    public function clearHistory(int $projectId): void;
}

