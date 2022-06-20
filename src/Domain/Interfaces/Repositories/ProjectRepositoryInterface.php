<?php

namespace ZnTool\RestClient\Domain\Interfaces\Repositories;

use ZnCore\Base\Libs\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Base\Exceptions\NotFoundException;
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
