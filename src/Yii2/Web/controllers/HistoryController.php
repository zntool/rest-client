<?php

namespace ZnTool\RestClient\Yii2\Web\controllers;

use yii\base\Module;
use yii\filters\AccessControl;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnLib\Rest\Yii2\Helpers\Behavior;
use ZnTool\RestClient\Domain\Enums\RestClientPermissionEnum;
use ZnTool\RestClient\Domain\Interfaces\Services\BookmarkServiceInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;

class HistoryController extends BaseController
{

    protected $bookmarkService;
    protected $projectService;
    private $toastrService;

    public function __construct(
        $id, Module $module,
        array $config = [],
        BookmarkServiceInterface $bookmarkService,
        ProjectServiceInterface $projectService,
        ToastrServiceInterface $toastrService
    )
    {
        parent::__construct($id, $module, $config);
        $this->bookmarkService = $bookmarkService;
        $this->projectService = $projectService;
        $this->toastrService = $toastrService;
    }

    public function behaviors()
    {
        return [
            'authenticator' => Behavior::auth(['delete', 'clear']),
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [RestClientPermissionEnum::PROJECT_WRITE],
                        'actions' => ['delete', 'clear'],
                    ],
                ],
            ],
            'verb' => Behavior::verb([
                'delete' => ['post'],
                'clear' => ['post'],
            ]),
        ];
    }

    public function actionDelete($tag)
    {
        $projectEntity = $this->getProjectByHash($tag);
        $this->bookmarkService->removeByHash($tag);
        $this->toastrService->success('Request was removed from history successfully.');
        //$this->toastrService->success('Request was removed from history successfully.');
        return $this->redirect(['/rest-client/request/send', 'projectName' => $projectEntity->getName()]);
    }

    public function actionClear(string $projectName)
    {
        $projectEntity = $this->getProjectByName($projectName);
        $this->bookmarkService->clearHistory($projectEntity->getId());
        $this->toastrService->success('History was cleared successfully.');
        return $this->redirect(['/rest-client/request/send', 'projectName' => $projectEntity->getName()]);
    }
}