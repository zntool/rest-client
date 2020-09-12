<?php

namespace ZnTool\RestClient\Yii\Web\controllers;

use ZnTool\RestClient\Domain\Enums\RestClientPermissionEnum;
use ZnTool\RestClient\Domain\Helpers\Postman\PostmanHelper;
use ZnTool\RestClient\Domain\Interfaces\Services\BookmarkServiceInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use Yii;
use yii\base\Module;
use yii2bundle\navigation\domain\widgets\Alert;
use yii2bundle\rest\domain\helpers\MiscHelper;
use yii2rails\extension\web\helpers\Behavior;

/**
 * Class CollectionController
 *
 * @author Roman Zhuravlev <zhuravljov@gmail.com>
 */
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

    public function authentication(): array
    {
        return [
            'link',
            'unlink',
        ];
    }

    public function access(): array
    {
        return [
            [
                [RestClientPermissionEnum::PROJECT_WRITE], ['link', 'unlink'],
            ],
        ];
    }

    public function verbs(): array
    {
        return [
            'link' => ['post'],
            'unlink' => ['post'],
        ];
    }

    public function actionLink($tag)
    {
        $projectEntity = $this->getProjectByHash($tag);
        $this->bookmarkService->addToCollection($tag);
        \App::$domain->navigation->alert->create('Request was added to collection successfully.', Alert::TYPE_SUCCESS);
        return $this->redirect(['/rest-client/request/send', 'projectName' => $projectEntity->getName(), 'tag' => $tag]);
    }

    public function actionUnlink($tag)
    {
        $projectEntity = $this->getProjectByHash($tag);
        $this->bookmarkService->removeByHash($tag);
        \App::$domain->navigation->alert->create('Request was removed from collection successfully.', Alert::TYPE_SUCCESS);
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