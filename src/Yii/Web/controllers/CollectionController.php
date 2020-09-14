<?php

namespace ZnTool\RestClient\Yii\Web\controllers;

use yii\filters\AccessControl;
use ZnTool\RestClient\Domain\Enums\RestClientPermissionEnum;
use ZnTool\RestClient\Domain\Helpers\Postman\PostmanHelper;
use ZnTool\RestClient\Domain\Interfaces\Services\BookmarkServiceInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use Yii;
use yii\base\Module;
use yii2bundle\navigation\domain\widgets\Alert;
use yii2bundle\rest\domain\helpers\MiscHelper;
use ZnSandbox\Sandbox\Yii2\Helpers\Behavior;

class CollectionController extends BaseController
{
    /**
     * @var \ZnTool\RestClient\Yii\Web\Module
     */
    public $module;

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
            'authenticator' => Behavior::auth(['link', 'unlink',]),
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [RestClientPermissionEnum::PROJECT_WRITE],
                        'actions' => ['link', 'unlink'],
                    ],
                ],
            ],
            'verb' => Behavior::verb([
                'link' => ['post'],
                'unlink' => ['post'],
            ]),
        ];
    }

    public function actionLink($tag)
    {
        $projectEntity = $this->getProjectByHash($tag);
        $this->bookmarkService->addToCollection($tag);
        \ZnSandbox\Sandbox\Html\Yii2\Widgets\Toastr\widgets\Alert::create('Request was added to collection successfully.', Alert::TYPE_SUCCESS);
        return $this->redirect(['/rest-client/request/send', 'projectName' => $projectEntity->getName(), 'tag' => $tag]);
    }

    public function actionUnlink($tag)
    {
        $projectEntity = $this->getProjectByHash($tag);
        $this->bookmarkService->removeByHash($tag);
        \ZnSandbox\Sandbox\Html\Yii2\Widgets\Toastr\widgets\Alert::create('Request was removed from collection successfully.', Alert::TYPE_SUCCESS);
        return $this->redirect(['/rest-client/request/send', 'projectName' => $projectEntity->getName()]);
    }

    public function actionExportPostman($postmanVersion)
    {
        $collection = $this->bookmarkService->allFavoriteByProject(1);

        $cc = PostmanHelper::splitByGroup($collection);
        $postmanCollection = PostmanHelper::genFromCollection($cc, 'v1');
        $jsonContent = json_encode($postmanCollection, JSON_PRETTY_PRINT);

        $apiVersion = MiscHelper::currentApiVersion();
        $collectionName = MiscHelper::collectionNameFormatId();
        $fileName = $collectionName . '-' . date('Y-m-d-H-i-s') . '.json';

        return Yii::$app->response->sendContentAsFile(
            $jsonContent,
            $fileName
        );
    }

}