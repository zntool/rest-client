<?php

namespace ZnTool\RestClient\Yii2\Web\models;

use ZnLib\Components\I18Next\Facades\I18Next;
use yii\base\Model;

class ProjectForm extends Model
{

    public $name;
    public $title;
    //public $url;

    public function rules()
    {
        return [
            [['name', 'title'/*, 'url'*/], 'required'],
            //['url', 'url'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => I18Next::t('restclient', 'project.attributes.name'),
            'title' => I18Next::t('restclient', 'project.attributes.title'),
            //'url' => I18Next::t('restclient', 'project.attributes.url'),
        ];
    }

}