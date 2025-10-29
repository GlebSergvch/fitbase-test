<?php

use yii\helpers\Html;

$this->title = 'Обновить клуб';
?>
<div class="club-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>