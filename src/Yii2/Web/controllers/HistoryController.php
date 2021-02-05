<?php

namespace ZnTool\RestClient\Yii2\Web\controllers;

use yii\filters\AccessControl;
use ZnLib\Rest\Yii2\Helpers\Behavior;
use ZnTool\RestClient\Domain\Enums\RestClientPermissionEnum;
use ZnTool\RestClient\Domain\Interfaces\Services\BookmarkServiceInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use yii\base\Module;
use ZnYii\Web\Widgets\Toastr\Toastr;

class HistoryController extends BaseController
{

    protected $bookmarkService;
    protected $projectService;

    public function __construct(
        $id, Module $module,
        array $config = [],
        BookmarkServiceInterface $bookmarkService,
        ProjectServiceInterface $projectService
    )
    {
        parent::__construct($id, $module, $config);
        $this->bookmarkService = $bookmarkService;
        $this->projectService = $projectService;
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
        \ZnYii\Web\Widgets\Toastr\Toastr::create('Request was removed from history successfully.', Toastr::TYPE_SUCCESS);
        //\ZnYii\Web\Widgets\Toastr\Toastr::create('Request was removed from history successfully.', Toastr::TYPE_SUCCESS);
        return $this->redirect(['/rest-client/request/send', 'projectName' => $projectEntity->getName()]);
    }

    public function actionClear(string $projectName)
    {
        $projectEntity = $this->getProjectByName($projectName);
        $this->bookmarkService->clearHistory($projectEntity->getId());
        \ZnYii\Web\Widgets\Toastr\Toastr::create('History was cleared successfully.', Toastr::TYPE_SUCCESS);
        return $this->redirect(['/rest-client/request/send', 'projectName' => $projectEntity->getName()]);
    }
}