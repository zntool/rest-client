<?php

use ZnLib\Components\I18Next\Facades\I18Next;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 */

$this->title = I18Next::t('restclient', 'project.create_title');

?>

<div class="col-lg-12">
    <h2>
        <?= $this->title ?>
    </h2>
</div>

<div class="col-lg-5">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
