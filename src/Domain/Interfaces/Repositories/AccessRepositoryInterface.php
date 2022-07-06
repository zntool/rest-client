<?php

namespace ZnTool\RestClient\Domain\Interfaces\Repositories;

use ZnCore\Collection\Interfaces\Enumerable;
use ZnCore\Entity\Exceptions\NotFoundException;
use ZnCore\Repository\Interfaces\CrudRepositoryInterface;
use ZnTool\RestClient\Domain\Entities\AccessEntity;

interface AccessRepositoryInterface extends CrudRepositoryInterface
{

    /**
     * @param int $projectId
     * @param int $userId
     * @return AccessEntity
     * @throws NotFoundException
     */
    public function findOneByTie(int $projectId, int $userId): AccessEntity;

    public function allByUserId(int $userId): Enumerable;

}
