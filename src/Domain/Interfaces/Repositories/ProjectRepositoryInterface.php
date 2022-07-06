<?php

namespace ZnTool\RestClient\Domain\Interfaces\Repositories;

use ZnCore\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Entity\Exceptions\NotFoundException;
use ZnTool\RestClient\Domain\Entities\ProjectEntity;

interface ProjectRepositoryInterface extends CrudRepositoryInterface
{

    /**
     * @param string $projectName
     * @return ProjectEntity
     * @throws NotFoundException
     */
    public function findOneByName(string $projectName): ProjectEntity;

}
