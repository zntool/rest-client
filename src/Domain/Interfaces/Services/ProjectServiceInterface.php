<?php

namespace ZnTool\RestClient\Domain\Interfaces\Services;

use ZnCore\Service\Interfaces\CrudServiceInterface;
use ZnCore\Entity\Exceptions\NotFoundException;
use ZnTool\RestClient\Domain\Entities\ProjectEntity;

interface ProjectServiceInterface extends CrudServiceInterface
{

    public function allWithoutUserId(int $userId);

    public function allByUserId(int $userId);

    public function isAllowProject(int $projectId, int $userId);

    /**
     * @param string $projectName
     * @return ProjectEntity
     * @throws NotFoundException
     */
    public function findOneByName(string $projectName): ProjectEntity;

    /**
     * @param string $tag
     * @return string
     * @throws NotFoundException
     */
    public function projectNameByHash(string $tag): string;

}
