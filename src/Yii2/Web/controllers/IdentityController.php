<?php

namespace ZnTool\RestClient\Yii2\Web\controllers;

use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnBundle\User\Domain\Enums\UserPermissionEnum;
use ZnBundle\User\Domain\Interfaces\Services\IdentityServiceInterface;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Helpers\EntityHelper;
use ZnLib\Rest\Yii2\Helpers\Behavior;
use ZnLib\Web\Yii2\Helpers\ErrorHelper;
use ZnTool\RestClient\Domain\Interfaces\Services\AccessServiceInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use ZnTool\RestClient\Yii2\Web\models\IdentityForm;

//use yii2rails\domain\exceptions\UnprocessableEntityHttpException;

class IdentityController extends BaseController
{

    protected $projectService;
    protected $identityService;
    protected $accessService;
    private $toastrService;

    public function __construct(
        $id, Module $module,
        array $config = [],
        ProjectServiceInterface $projectService,
        IdentityServiceInterface $identityService,
        AccessServiceInterface $accessService,
        ToastrServiceInterface $toastrService
    )
    {
        parent::__construct($id, $module, $config);
        $this->projectService = $projectService;
        $this->identityService = $identityService;
        $this->accessService = $accessService;
        $this->toastrService = $toastrService;
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
                        'roles' => [UserPermissionEnum::IDENTITY_READ],
                        'actions' => ['create', 'update', 'delete'],
                    ],
                    [
                        'allow' => true,
                        'roles' => [UserPermissionEnum::IDENTITY_WRITE],
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
                $this->identityService->create($model->toArray());
            } catch (UnprocessableEntityHttpException $e) {
                ErrorHelper::handleError($e, $model);
            }
            $this->toastrService->success(I18Next::t('restclient', 'identity.messages.created_success'));
            return $this->redirect(['/rest-client/identity/index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = new IdentityForm;
        if (Yii::$app->request->isPost) {
            $body = Yii::$app->request->post();
            $model->load($body, 'IdentityForm');
            $this->identityService->updateById($id, $model->toArray());
            $this->toastrService->success(I18Next::t('restclient', 'identity.messages.updated_success'));
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
        $this->identityService->deleteById($id);
        $this->toastrService->success(I18Next::t('restclient', 'identity.messages.deleted_success'));
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
        $this->toastrService->success(I18Next::t('restclient', 'access.messages.created_success'));
        return $this->redirect(['/rest-client/identity/view', 'id' => $userId]);
    }

    public function actionDetach($projectId, $userId)
    {
        $this->accessService->detach($projectId, $userId);
        $this->toastrService->success(I18Next::t('restclient', 'access.messages.deleted_success'));
        return $this->redirect(['/rest-client/identity/view', 'id' => $userId]);
    }
}