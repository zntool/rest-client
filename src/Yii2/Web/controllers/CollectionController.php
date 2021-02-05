<?php

namespace ZnTool\RestClient\Yii2\Web\controllers;

use Yii;
use yii\base\Module;
use yii2bundle\rest\domain\helpers\MiscHelper;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnLib\Rest\Yii2\Helpers\Behavior;
use ZnTool\RestClient\Domain\Helpers\Postman\PostmanHelper;
use ZnTool\RestClient\Domain\Interfaces\Services\BookmarkServiceInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;

class CollectionController extends BaseController
{
    /**
     * @var \ZnTool\RestClient\Yii2\Web\Module
     */
    public $module;

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
            'authenticator' => Behavior::auth(['link', 'unlink',]),
            /*'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [RestClientPermissionEnum::PROJECT_WRITE],
                        'actions' => ['link', 'unlink'],
                    ],
                ],
            ],*/
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
        $this->toastrService->success('Request was added to collection successfully.');
        return $this->redirect(['/rest-client/request/send', 'projectName' => $projectEntity->getName(), 'tag' => $tag]);
    }

    public function actionUnlink($tag)
    {
        $projectEntity = $this->getProjectByHash($tag);
        $this->bookmarkService->removeByHash($tag);
        $this->toastrService->success('Request was removed from collection successfully.');
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