<?php

namespace ZnTool\RestClient\Yii2\Web;

use yii\web\AssetBundle;

class HighlightAsset extends AssetBundle
{
    public $baseUrl = '//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.8.0';
    public $css = [
        'styles/default.min.css',
    ];
    public $js = [
        'highlight.min.js',
    ];
    public $depends = [
    ];
}