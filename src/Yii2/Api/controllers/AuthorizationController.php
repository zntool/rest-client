<?php

namespace ZnTool\RestClient\Yii2\Api\controllers;

use ZnTool\RestClient\Domain\Enums\RestClientPermissionEnum;
use ZnTool\RestClient\Domain\Interfaces\Services\AccessServiceInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\AuthorizationServiceInterface;
use ZnTool\RestClient\Domain\Interfaces\Services\ProjectServiceInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use yii\base\Module;
use ZnLib\Rest\Yii2\Base\BaseCrudController;

class AuthorizationController extends BaseCrudController
{

	public function __construct(
	    string $id,
        Module $module,
        array $config = [],
        AuthorizationServiceInterface $authorizationService
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $authorizationService;
    }

    protected function normalizerContext(): array
    {
        return [
            AbstractNormalizer::IGNORED_ATTRIBUTES => ['password'],
        ];
    }

    public function authentication(): array
    {
        return [
            'create',
            'update',
            'delete',
            'index',
            'view',
        ];
    }

    public function access(): array
    {
        return [
            [
                [RestClientPermissionEnum::PROJECT_WRITE], ['create', 'update', 'delete'],
            ],
            [
                [RestClientPermissionEnum::PROJECT_READ], ['index', 'view'],
            ],
        ];
    }

}