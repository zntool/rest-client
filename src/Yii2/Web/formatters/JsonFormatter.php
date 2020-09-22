<?php

namespace ZnTool\RestClient\Yii2\Web\formatters;

use yii\base\InvalidArgumentException;
use yii\helpers\Json;

class JsonFormatter extends RawFormatter
{

    public function getName(): string
    {
        return 'json';
    }

    public function format(string $content): string
    {
        $data = Json::decode($content);
        $jsonContent = Json::encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return $jsonContent;
    }
}