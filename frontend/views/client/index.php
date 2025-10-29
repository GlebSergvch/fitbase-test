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
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true], // убрали 'class' => 'form-inline'
    ]); ?>

    <div class="row align-items-end"> <!-- align-items-end чтобы кнопка выровнялась -->
        <div class="col-md-3">
            <?= $form->field($searchModel, 'full_name')->textInput(['placeholder' => 'ФИО', 'class' => 'form-control']) ?>
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

        <div class="col-md-3 text-md-right" style="padding-top: 0;">
            <?= Html::submitButton('Фильтр', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::begin(['id' => 'client-pjax']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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