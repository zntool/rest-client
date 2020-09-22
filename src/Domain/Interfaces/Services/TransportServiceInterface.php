<?php

namespace ZnTool\RestClient\Domain\Interfaces\Services;

use ZnTool\RestClient\Domain\Entities\ProjectEntity;
use Psr\Http\Message\ResponseInterface;
use ZnTool\RestClient\Yii2\Web\models\RequestForm;

interface TransportServiceInterface
{

    public function send(ProjectEntity $projectEntity, RequestForm $model): ResponseInterface;

}

