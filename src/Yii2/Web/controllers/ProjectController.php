<?php

namespace ZnTool\RestClient\Yii2\Web\controllers;

use Packages\Common\Enums\Rbac\ApplicationPermissionEnum;
use Yii;
use yii\base\Module;
use yii\filters\AccessControl;
use ZnBundle\Notify\Domain\Interfaces\Services\ToastrServiceInterface;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Base\Libs\Entity\Helpers\EntityHelper;
use ZnLib\Rest\Yii2\Helpers\Behavior;
use ZnTool\RestClient\Domain\Enums\RestClientPermissionEnum;
use ZnTool\RestClient\Domain\Interfaces\Services\EnvironmentServiceInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use ZnTool\RestClient\Yii2\Web\models\ProjectForm;

class ProjectController extends BaseController
{

    protected $projectService;
    protected $environmentService;
    private $toastrService;

    public function __construct(
        $id, Module $module,
        array $config = [],
        ProjectServiceInterface $projectService,
        EnvironmentServiceInterface $environmentService,
        ToastrServiceInterface $toastrService
    )
    {
        parent::__construct($id, $module, $config);
        $this->projectService = $projectService;
        $this->environmentService = $environmentService;
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
                        'roles' => [RestClientPermissionEnum::ACCESS_MANAGE],
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

    public function actionIndex()
    {
        if (Yii::$app->user->can(ApplicationPermissionEnum::BACKEND_ALL)) {
            $projectCollection = $this->projectService->all();
        } else {
            $projectCollection = $this->projectService->allByUserId(Yii::$app->user->identity->id);
        }
        return $this->render('index', [
            'projectCollection' => $projectCollection,
        ]);
    }

    public function actionView($id)
    {
        $projectEntity = $this->projectService->oneById($id);
        $environmentCollection = $this->environmentService->allByProjectId($id);
        return $this->render('view', [
            'projectEntity' => $projectEntity,
            'environmentCollection' => $environmentCollection,
        ]);
    }

    public function actionCreate()
    {
        $model = new ProjectForm;
        if (Yii::$app->request->isPost) {
            $body = Yii::$app->request->post();
            $model->load($body, 'ProjectForm');
            $this->projectService->create($model->toArray());
            $this->toastrService->success(I18Next::t('restclient', 'project.messages.created_success'));
            return $this->redirect(['/rest-client/project/index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->projectService->deleteById($id);
        $this->toastrService->success(I18Next::t('restclient', 'project.messages.deleted_success'));
        return $this->redirect(['/rest-client/project/index']);
    }

    public function actionUpdate($id)
    {
        $model = new ProjectForm;
        if (Yii::$app->request->isPost) {
            $body = Yii::$app->request->post();
            $model->load($body, 'ProjectForm');
            $this->projectService->updateById($id, $model->toArray());
            $this->toastrService->success(I18Next::t('restclient', 'project.messages.updated_success'));
            return $this->redirect(['/rest-client/project/index']);
        } else {
            $projectEntity = $this->projectService->oneById($id);
            $model->load(EntityHelper::toArray($projectEntity), '');
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}