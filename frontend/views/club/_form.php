<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();

echo $form->field($model, 'name')->textInput(['maxlength' => true]);
echo $form->field($model, 'address')->textarea(['rows' => 3]);

echo '<div class="form-group">';
echo Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']);
echo '</div>';

ActiveForm::end();