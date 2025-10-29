<?php

use yii\helpers\Html;

$this->title = 'Обновить клиента';
?>
<div class="client-form client-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>