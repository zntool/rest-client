<?php

namespace ZnTool\RestClient\Domain\Services;

use Illuminate\Support\Collection;
use ZnCore\Domain\Entity\Helpers\EntityHelper;
use ZnCore\Domain\Entity\Exceptions\NotFoundException;
use ZnTool\RestClient\Domain\Entities\BookmarkEntity;
use ZnTool\RestClient\Domain\Enums\StatusEnum;
use ZnTool\RestClient\Domain\Interfaces\Repositories\BookmarkRepositoryInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\BookmarkServiceInterface;
use ZnCore\Domain\Service\Base\BaseCrudService;

class BookmarkService extends BaseCrudService implements BookmarkServiceInterface
{

    public function __construct(BookmarkRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }

    public function persist(object $bookmarkEntity) {
        $bookmarkEntity->setId(null);
        try {
            $bookmarkEntity = $this->getRepository()->findOneByHash($bookmarkEntity->getHash());
            $this->getRepository()->update($bookmarkEntity);
        } catch (NotFoundException $e) {
            $bookmarkEntity->setStatus(StatusEnum::HISTORY);
            $this->getRepository()->create($bookmarkEntity);
        }
        return $bookmarkEntity;
    }

    public function createOrUpdate(array $data): BookmarkEntity {
        $bookmarkEntity = new BookmarkEntity;
        unset($data['id']);
        EntityHelper::setAttributes($bookmarkEntity, $data);
        try {
            $bookmarkEntity = $this->getRepository()->findOneByHash($bookmarkEntity->getHash());
            $this->getRepository()->update($bookmarkEntity);
        } catch (NotFoundException $e) {
            $bookmarkEntity->setStatus(StatusEnum::HISTORY);
            $this->getRepository()->create($bookmarkEntity);
        }
        return $bookmarkEntity;
    }

    public function addToCollection(string $hash): BookmarkEntity {
        $bookmarkEntity = $this->getRepository()->findOneByHash($hash);
        $bookmarkEntity->setStatus(StatusEnum::FAVORITE);
        $this->getRepository()->update($bookmarkEntity);
        return $bookmarkEntity;
    }

    public function removeByHash(string $hash): void {
        $this->getRepository()->removeByHash($hash);
    }

    public function findOneByHash(string $hash): BookmarkEntity {
        return $this->getRepository()->findOneByHash($hash);
    }

    public function allFavoriteByProject(int $projectId): Collection {
        return $this->getRepository()->allFavoriteByProject($projectId);
    }

    public function allHistoryByProject(int $projectId): Collection {
        return $this->getRepository()->allHistoryByProject($projectId);
    }

    public function clearHistory(int $projectId): void {
        $this->getRepository()->clearHistory($projectId);
    }
}
