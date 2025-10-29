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
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true, 'class' => 'form-inline'],
    ]); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($searchModel, 'name')->textInput(['placeholder' => 'Название']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($searchModel, 'archive')->checkbox(['label' => 'Показать архив']) ?>
        </div>
        <div class="col-md-2" style="padding-top: 25px;">
            <?= Html::submitButton('Фильтр', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::begin(['id' => 'club-pjax']); ?>
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