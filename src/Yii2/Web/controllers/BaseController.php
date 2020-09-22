<?php

namespace ZnTool\RestClient\Yii2\Web\controllers;

use ZnCore\Base\Exceptions\NotFoundException;
use ZnTool\RestClient\Domain\Entities\ProjectEntity;
use ZnTool\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\rest\Controller;

abstract class BaseController extends Controller
{
    /** @var ProjectServiceInterface */
    protected $projectService;

    protected function getProjectByHash(string $tag): ProjectEntity
    {
        $projectName = $this->projectService->projectNameByHash($tag);
        return $this->getProjectByName($projectName);
    }

    protected function getProjectByName(string $projectName): ProjectEntity
    {
        try {
            $projectEntity = $this->projectService->oneByName($projectName);
            $userId = Yii::$app->user->identity->getId();
            $isAllow = $this->projectService->isAllowProject($projectEntity->getId(), $userId);
            if ( ! $isAllow) {
                throw new ForbiddenHttpException('Project not allow!');
            }
        } catch (NotFoundException $e) {
            throw new NotFoundHttpException('Project not found!');
        }
        return $projectEntity;
    }

}