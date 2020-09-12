<?php

namespace ZnTool\RestClient\Yii\Web\formatters;

class HtmlFormatter extends RawFormatter
{

    public function getName(): string
    {
        return 'html';
    }

}