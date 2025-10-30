<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

$this->title = 'Клубы';
?>
<div class="club-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить клуб', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $form = ActiveForm::begin([
        'id' => 'club-filter-form',
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true, 'class' => 'form-inline'],
    ]); ?>

    <div class="row align-items-end row-filter">
        <div class="col-md-3">
            <?= $form->field($searchModel, 'name')->textInput(['placeholder' => 'Название']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($searchModel, 'archive')->checkbox(['label' => 'Показать архив']) ?>
        </div>
        <div class="col-md-1 text-md-right" style="padding-top: 25px;">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="col-md-1 text-md-right" style="padding-top: 25px;">
            <?= Html::a('Сбросить', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::begin([
        'id' => 'club-pjax',
        'timeout' => 5000,
        'enablePushState' => false,
        'formSelector' => '#club-filter-form', // <- добавлено
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'address:ntext',
            ['attribute' => 'created_at', 'format' => ['datetime', 'php:d.m.Y H:i']],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>