<?php

namespace ZnTool\RestClient\Domain\Interfaces\Repositories;

use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Domain\Entity\Exceptions\NotFoundException;
use ZnTool\RestClient\Domain\Entities\ProjectEntity;

interface ProjectRepositoryInterface extends CrudRepositoryInterface
{

    /**
     * @param string $projectName
     * @return ProjectEntity
     * @throws NotFoundException
     */
    public function oneByName(string $projectName): ProjectEntity;

}
