<?php

use ZnLib\Components\I18Next\Facades\I18Next;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \ZnBundle\User\Domain\Entities\EnvironmentEntity $environmentEntity
 * @var \ZnTool\RestClient\Domain\Entities\ProjectEntity[] | \ZnCore\Domain\Collection\Interfaces\Enumerable $projectCollection
 * @var \ZnTool\RestClient\Domain\Entities\ProjectEntity[] | \ZnCore\Domain\Collection\Interfaces\Enumerable $hasProjectCollection
 */

$this->title = $environmentEntity->getTitle();

?>

<div class="col-lg-12">
    <div class="pull-right">
        <a href="<?= Url::to(['/rest-client/environment/update', 'id' => $environmentEntity->getId()]) ?>"
           class="btn btn-primary"><?= I18Next::t('core', 'action.update') ?></a>
    </div>
    <h2>
        <?= $this->title ?>
    </h2>
</div>
