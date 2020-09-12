<?php

namespace ZnTool\RestClient\Yii\Web\formatters;

use yii\base\ErrorException;
use yii\base\InvalidArgumentException;

class RawFormatter
{

    public function getName(): string
    {
        return 'raw';
    }

    /**
     * @param string $content
     * @return string
     * @throws ErrorException
     * @throws InvalidArgumentException
     */
    public function format(string $content): string
    {
        return $content;
    }

}