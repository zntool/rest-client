<?php

namespace ZnTool\RestClient\Domain\Interfaces\Repositories;

use Illuminate\Support\Collection;
use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Domain\Entity\Exceptions\NotFoundException;
use ZnTool\RestClient\Domain\Entities\AccessEntity;

interface AccessRepositoryInterface extends CrudRepositoryInterface
{

    /**
     * @param int $projectId
     * @param int $userId
     * @return AccessEntity
     * @throws NotFoundException
     */
    public function oneByTie(int $projectId, int $userId): AccessEntity;

    public function allByUserId(int $userId): Collection;

}
