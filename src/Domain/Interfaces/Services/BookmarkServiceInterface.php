<?php

namespace ZnTool\RestClient\Domain\Interfaces\Services;

use ZnCore\Validation\Exceptions\UnprocessibleEntityException;
use ZnCore\Collection\Interfaces\Enumerable;
use ZnCore\Entity\Exceptions\NotFoundException;
use ZnCore\Service\Interfaces\CrudServiceInterface;
use ZnTool\RestClient\Domain\Entities\BookmarkEntity;

interface BookmarkServiceInterface extends CrudServiceInterface
{

    /**
     * @param array $data
     * @return BookmarkEntity
     * @throws UnprocessibleEntityException
     */
    public function createOrUpdate(array $data): BookmarkEntity;

    /**
     * @param string $hash
     * @return BookmarkEntity
     * @throws NotFoundException
     */
    public function addToCollection(string $hash): BookmarkEntity;

    /**
     * @param string $hash
     * @return void
     * @throws NotFoundException
     */
    public function removeByHash(string $hash): void;

    /**
     * @param string $hash
     * @return BookmarkEntity
     * @throws NotFoundException
     */
    public function findOneByHash(string $hash): BookmarkEntity;

    /**
     * @param int $projectId
     * @return Enumerable
     */
    public function allFavoriteByProject(int $projectId): Enumerable;

    /**
     * @param int $projectId
     * @return Enumerable
     */
    public function allHistoryByProject(int $projectId): Enumerable;

    /**
     * @param int $projectId
     * @return void
     */
    public function clearHistory(int $projectId): void;
}

