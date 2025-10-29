<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use common\models\Club;

$form = ActiveForm::begin();

echo $form->field($model, 'full_name')->textInput(['maxlength' => true]);

echo $form->field($model, 'gender')->radioList(['male' => 'Мужской', 'female' => 'Женский']);

echo $form->field($model, 'birth_date')->widget(DatePicker::class, [
    'options' => ['placeholder' => 'Дата рождения'],
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'autoclose' => true,
        'orientation' => 'bottom',
    ],
]);

echo $form->field($model, 'club_ids')->widget(Select2::class, [
    'data' => Club::find()->select(['name', 'id'])->indexBy('id')->column(),
    'options' => ['placeholder' => 'Выберите клубы...', 'multiple' => true],
    'pluginOptions' => ['allowClear' => true],
]);

echo '<div class="form-group">';
echo Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']);
echo '</div>';

ActiveForm::end();