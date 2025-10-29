<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name ?? $model->full_name;
?>
<div class="club-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'address:ntext',
            'created_at:datetime',
            ['label' => 'Создано', 'value' => $model->createdBy->username ?? '-'],
            'updated_at:datetime',
            ['label' => 'Обновлено', 'value' => $model->updatedBy->username ?? '-'],
        ],
    ]) ?>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => ['confirm' => 'Удалить?', 'method' => 'post'],
        ]) ?>
    </p>
</div>