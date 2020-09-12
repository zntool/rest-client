<?php

use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \ZnTool\RestClient\Yii\Web\models\ProjectForm $model
 */

?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'login')->textInput() ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<div class="form-group">
    <?= Html::submitButton(I18Next::t('core', 'action.send'), ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
