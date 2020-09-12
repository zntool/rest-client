<?php

namespace ZnTool\RestClient\Yii\Web;

use Yii;
use ZnTool\RestClient\Domain\Enums\RestClientPermissionEnum;
use yii\filters\AccessControl;

class Module extends \yii\base\Module
{

    public $defaultRoute = 'request';

    public $formatters = [
        'application/json' => 'ZnTool\RestClient\Yii\Web\formatters\JsonFormatter',
        'application/xml' => 'ZnTool\RestClient\Yii\Web\formatters\XmlFormatter',
        'text/html' => 'ZnTool\RestClient\Yii\Web\formatters\HtmlFormatter',
    ];

    public function behaviors()
    {
        return [
            'as access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [RestClientPermissionEnum::PROJECT_READ],
                    ],
                ],
            ]
        ];
    }

}
