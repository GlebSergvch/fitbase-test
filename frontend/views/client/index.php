<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;

$this->title = 'Клиенты';
?>
<div class="client-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить клиента', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $form = ActiveForm::begin([
        'id' => 'client-filter-form',
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true],
    ]); ?>

    <div class="row align-items-end client-filter row-filter">
        <div class="col-md-2">
            <?= $form->field($searchModel, 'full_name')->textInput(['placeholder' => 'ФИО', 'class' => 'form-control'])->label(false) ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($searchModel, 'gender')->radioList(['male' => 'Муж', 'female' => 'Жен'])->label(false) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($searchModel, 'date_range', [
                'options' => ['class' => 'form-group mb-0'],
                'template' => "{input}\n{hint}\n{error}"
            ])->widget(DateRangePicker::class, [
                'convertFormat' => false,
                'startAttribute' => 'date_from',
                'endAttribute' => 'date_to',
                'pluginOptions' => [
                    'locale' => ['format' => 'YYYY-MM-DD'],
                    'opens' => 'right',
                    'autoUpdateInput' => true,
                    'showDropdowns' => true,
                    'linkedCalendars' => false,
                ],
                'options' => ['placeholder' => 'Выберите период', 'class' => 'form-control'],
            ])->label(false) ?>
        </div>

        <div class="col-md-1 text-md-right" style="padding-top: 0;">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        </div>

        <div class="col-md-1 text-md-right" style="padding-top: 0;">
            <?= Html::a('Сбросить', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <hr/>

    <?php Pjax::begin([
        'id' => 'client-pjax',
        'timeout' => 5000,
        'enablePushState' => false,
        'formSelector' => '#client-filter-form', // <- добавлено
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'columns' => [
            'full_name',
            'gender',
            ['attribute' => 'birth_date', 'format' => ['date', 'php:d.m.Y']],
            ['attribute' => 'created_at', 'format' => ['datetime', 'php:d.m.Y H:i']],
            ['attribute' => 'updated_at', 'format' => ['datetime', 'php:d.m.Y H:i']],
            ['attribute' => 'deleted_at', 'format' => ['datetime', 'php:d.m.Y H:i']],
            [
                'label' => 'Клубы',
                'value' => fn($model) => implode(', ', $model->getClubNames()),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
