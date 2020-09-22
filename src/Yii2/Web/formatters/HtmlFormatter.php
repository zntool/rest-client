<?php

namespace ZnTool\RestClient\Yii2\Web\formatters;

class HtmlFormatter extends RawFormatter
{

    public function getName(): string
    {
        return 'html';
    }

}