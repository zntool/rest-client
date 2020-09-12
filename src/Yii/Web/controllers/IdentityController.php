<?php

namespace ZnTool\RestClient\Yii\Web\controllers;

use kartik\alert\Alert;
use yii\filters\AccessControl;
use ZnSandbox\Sandbox\Yii2\Helpers\Behavior;
use ZnBundle\User\Domain\Interfaces\Services\IdentityServiceInterface;
use ZnCore\Domain\Exceptions\UnprocessibleEntityException;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnTool\RestClient\Domain\Interfaces\Services\AccessServiceInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use ZnTool\RestClient\Yii\Web\models\IdentityForm;
use Yii;
use yii\base\Module;
use yii2bundle\account\domain\v3\enums\AccountPermissionEnum;
use yii2rails\domain\base\Model;
use yii2rails\domain\exceptions\UnprocessableEntityHttpException;
use ZnSandbox\Sandbox\Web\Yii2\Helpers\ErrorHelper;

class IdentityController extends BaseController
{

    protected $projectService;
    protected $identityService;
    protected $accessService;

    public function __construct(
        $id, Module $module,
        array $config = [],
        ProjectServiceInterface $projectService,
        IdentityServiceInterface $identityService,
        AccessServiceInterface $accessService
    )
    {
        parent::__construct($id, $module, $config);
        $this->projectService = $projectService;
        $this->identityService = $identityService;
        $this->accessService = $accessService;
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
                        'roles' => [AccountPermissionEnum::IDENTITY_READ],
                        'actions' => ['create', 'update', 'delete'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [AccountPermissionEnum::IDENTITY_WRITE],
                        'actions' => ['index', 'view'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $identityCollection = $this->identityService->all();
        return $this->render('index', [
            'identityCollection' => $identityCollection,
        ]);
    }

    public function actionCreate()
    {
        $model = new IdentityForm;
        if (Yii::$app->request->isPost) {
            $body = Yii::$app->request->post();
            $model->load($body, 'IdentityForm');
            try {
                \App::$domain->account->identity->create($model->toArray());
            } catch (UnprocessableEntityHttpException $e) {
                ErrorHelper::handleError($e, $model);
            }
            \App::$domain->navigation->alert->create(I18Next::t('restclient', 'identity.messages.created_success'), Alert::TYPE_SUCCESS);
            return $this->redirect(['/rest-client/identity/index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id) {
        $model = new IdentityForm;
        if(Yii::$app->request->isPost) {
            $body = Yii::$app->request->post();
            $model->load($body, 'IdentityForm');
            $this->identityService->updateById($id, $model->toArray());
            \App::$domain->navigation->alert->create(I18Next::t('restclient', 'identity.messages.updated_success'), Alert::TYPE_SUCCESS);
            return $this->redirect(['/rest-client/identity/index']);
        } else {
            $entity = $this->identityService->oneById($id);
            $model->load(EntityHelper::toArray($entity), '');
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        \App::$domain->account->identity->deleteById($id);
        \App::$domain->navigation->alert->create(I18Next::t('restclient', 'identity.messages.deleted_success'), Alert::TYPE_SUCCESS);
        return $this->redirect(['/rest-client/identity/index']);
    }

    public function actionView($id)
    {
        $identityEntity = $this->identityService->oneById($id);
        $projectCollection = $this->projectService->allWithoutUserId($id);
        $hasProjectCollection = $this->projectService->allByUserId($id);
        return $this->render('view', [
            'identityEntity' => $identityEntity,
            'projectCollection' => $projectCollection,
            'hasProjectCollection' => $hasProjectCollection,
        ]);
    }

    public function actionAttach($projectId, $userId)
    {
        $this->accessService->attach($projectId, $userId);
        \App::$domain->navigation->alert->create(I18Next::t('restclient', 'access.messages.created_success'), Alert::TYPE_SUCCESS);
        return $this->redirect(['/rest-client/identity/view', 'id' => $userId]);
    }

    public function actionDetach($projectId, $userId)
    {
        $this->accessService->detach($projectId, $userId);
        \App::$domain->navigation->alert->create(I18Next::t('restclient', 'access.messages.deleted_success'), Alert::TYPE_SUCCESS);
        return $this->redirect(['/rest-client/identity/view', 'id' => $userId]);
    }
}