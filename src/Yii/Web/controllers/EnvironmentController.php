<?php

namespace ZnTool\RestClient\Yii\Web\controllers;

use kartik\alert\Alert;
use yii\filters\AccessControl;
use ZnSandbox\Sandbox\Yii2\Helpers\Behavior;
use ZnBundle\User\Domain\Interfaces\Services\IdentityServiceInterface;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnTool\RestClient\Domain\Enums\RestClientPermissionEnum;
use ZnTool\RestClient\Domain\Interfaces\Services\AccessServiceInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use ZnTool\RestClient\Yii\Web\models\EnvironmentForm;
use Yii;
use yii\base\Module;
use yii2bundle\account\domain\v3\enums\AccountPermissionEnum;
use yii2rails\domain\base\Model;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use ZnTool\RestClient\Domain\Interfaces\Services\EnvironmentServiceInterface;
use ZnSandbox\Sandbox\Web\Yii2\Helpers\ErrorHelper;

class EnvironmentController extends BaseController
{

    protected $projectService;
    protected $environmentService;

    public function __construct(
        $id, Module $module,
        array $config = [],
        ProjectServiceInterface $projectService,
        EnvironmentServiceInterface $environmentService
    )
    {
        parent::__construct($id, $module, $config);
        $this->projectService = $projectService;
        $this->environmentService = $environmentService;
    }

    public function behaviors()
    {
        return [
            'authenticator' => Behavior::auth([
                'create',
                'update',
                'delete',
                'index',
                'view',
            ]),
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [RestClientPermissionEnum::PROJECT_READ],
                        'actions' => ['create', 'update', 'delete'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [RestClientPermissionEnum::PROJECT_READ],
                        'actions' => ['index', 'view'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate(int $projectId)
    {
        $projectEntity = $this->projectService->oneById($projectId);
        $model = new EnvironmentForm;
        $model->project_id = $projectId;
        if (Yii::$app->request->isPost) {
            $body = Yii::$app->request->post();
            $model->load($body, 'EnvironmentForm');
            try {
                $this->environmentService->create($model->toArray());
                \ZnSandbox\Sandbox\Html\Yii2\Widgets\Toastr\widgets\Alert::create(I18Next::t('restclient', 'environment.messages.created_success'), Alert::TYPE_SUCCESS);
                return $this->redirect(['/rest-client/project/view', 'id' => $projectEntity->getId()]);
            } catch (UnprocessibleEntityException $e) {
                ErrorHelper::handleError($e, $model);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $environmentEntity = $this->environmentService->oneById($id);
        $model = new EnvironmentForm;
        $model->project_id = $environmentEntity->getProjectId();
        if (Yii::$app->request->isPost) {
            $body = Yii::$app->request->post();
            $model->load($body, 'EnvironmentForm');
            try {
                $this->environmentService->updateById($id, $model->toArray());
                \ZnSandbox\Sandbox\Html\Yii2\Widgets\Toastr\widgets\Alert::create(I18Next::t('restclient', 'environment.messages.updated_success'), Alert::TYPE_SUCCESS);
                return $this->redirect(['/rest-client/project/view', 'id' => $environmentEntity->getProjectId()]);
            } catch (UnprocessibleEntityException $e) {
                ErrorHelper::handleError($e, $model);
            }
        } else {
            $entity = $this->environmentService->oneById($id);
            $model->load(EntityHelper::toArray($entity), '');
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $environmentEntity = $this->environmentService->oneById($id);
        $this->environmentService->deleteById($id);
        \ZnSandbox\Sandbox\Html\Yii2\Widgets\Toastr\widgets\Alert::create(I18Next::t('restclient', 'environment.messages.deleted_success'), Alert::TYPE_SUCCESS);
        return $this->redirect(['/rest-client/project/view', 'id' => $environmentEntity->getProjectId()]);
    }

    /*public function actionView($id)
    {
        $environmentEntity = $this->environmentService->oneById($id);
        return $this->render('view', [
            'environmentEntity' => $environmentEntity,
        ]);
    }*/

}