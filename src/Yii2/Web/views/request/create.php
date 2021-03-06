<?php

/**
 * @var \yii\web\View $this
 * @var string $frame
 * @var \ZnTool\RestClient\Yii2\Web\models\RequestForm $model
 * @var \ZnTool\RestClient\Domain\Entities\ProjectEntity $projectEntity
 * @var \Psr\Http\Message\ResponseInterface $response
 */

if ($model->method) {
    $this->title = strtoupper($model->method) . ' ' . $model->endpoint;
} else {
    $this->title = 'New Request';
}

?>

<div class="rest-request-create">
    <div class="row">
        <div class="col-lg-8">
            <div class="rest-request-form">
                <?= \ZnTool\RestClient\Yii2\Web\Widgets\FormWidget::widget([
                    'projectId' => $projectEntity->getId(),
                    'model' => $model,
                ]) ?>
            </div>

            <?php if ($response): ?>
                <div id="response" class="rest-request-response">
                    <?= $this->render('response/index', [
                        'duration' => $duration,
                        'response' => $response,
                        'frame' => $frame,
                    ]) ?>
                </div>
            <?php endif ?>

        </div>
        <div class="col-lg-4">
            <?= \ZnTool\RestClient\Yii2\Web\Widgets\CollectionWidget::widget([
                'projectId' => $projectEntity->getId(),
                'tag' => $tag,
            ]) ?>
        </div>
    </div>
</div>

<?= $this->render('assets'); ?>
