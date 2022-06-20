<?php

namespace ZnTool\RestClient\Domain\Services;

use Packages\Common\Enums\Rbac\ApplicationPermissionEnum;
use ZnCore\Base\Libs\Query\Entities\Where;
use ZnCore\Base\Libs\Query\Enums\OperatorEnum;
use ZnCore\Base\Libs\Entity\Helpers\EntityHelper;
use ZnCore\Base\Libs\Query\Entities\Query;
use ZnCore\Base\Exceptions\NotFoundException;
use ZnTool\RestClient\Domain\Entities\ProjectEntity;
use ZnTool\RestClient\Domain\Interfaces\Repositories\AccessRepositoryInterface;
use ZnTool\RestClient\Domain\Interfaces\Repositories\BookmarkRepositoryInterface;
use ZnTool\RestClient\Domain\Interfaces\Repositories\ProjectRepositoryInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use ZnCore\Base\Libs\Service\Base\BaseCrudService;
use Yii;
use yii\web\NotFoundHttpException;

class ProjectService extends BaseCrudService implements ProjectServiceInterface
{

    private $bookmarkRepository;
    private $accessRepository;

    public function __construct(
        ProjectRepositoryInterface $repository,
        BookmarkRepositoryInterface $bookmarkRepository,
        AccessRepositoryInterface $accessRepository
    )
    {
        $this->setRepository($repository);
        $this->bookmarkRepository = $bookmarkRepository;
        $this->accessRepository = $accessRepository;
    }

    public function allWithoutUserId(int $userId)
    {
        $accessCollection = $this->accessRepository->allByUserId($userId);
        $projectIds = EntityHelper::getColumn($accessCollection, 'project_id');
        $query = new Query;
        $where = new Where('id', $projectIds, OperatorEnum::EQUAL, 'and', true);
        $query->whereNew($where);
        return $this->all($query);
    }

    public function allByUserId(int $userId)
    {
        $accessCollection = $this->accessRepository->allByUserId($userId);
        $projectIds = EntityHelper::getColumn($accessCollection, 'project_id');
        $query = new Query;
        $query->where('id', $projectIds);
        return $this->all($query);
    }

    public function isAllowProject(int $projectId, int $userId)
    {
        if (Yii::$app->user->can(ApplicationPermissionEnum::BACKEND_ALL)) {
            return true;
        }
        try {
            $this->accessRepository->oneByTie($projectId, $userId);
            return true;
        } catch (NotFoundException $e) {
            return false;
        }
    }

    public function oneByName(string $projectName): ProjectEntity
    {
        return $this->getRepository()->oneByName($projectName);
    }

    public function projectNameByHash(string $tag): string
    {
        try {
            $bookmarkEntity = $this->bookmarkRepository->oneByHash($tag);
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException('Project not found!');
        }

        try {
            $projectEntity = $this->oneById($bookmarkEntity->getProjectId());
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException('Project not found!');
        }
        return $projectEntity->getName();
    }
}

