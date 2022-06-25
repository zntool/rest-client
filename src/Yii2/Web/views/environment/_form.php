<?php

use ZnLib\Components\I18Next\Facades\I18Next;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \ZnTool\RestClient\Yii2\Web\models\ProjectForm $model
 */

?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'title')->textInput() ?>
<?= $form->field($model, 'url')->textInput() ?>
<div class="form-group">
    <?= Html::submitButton(I18Next::t('core', 'action.send'), ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
