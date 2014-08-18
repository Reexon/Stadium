<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/**
 * @var yii\web\View $this
 * @var backend\models\Match $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="match-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'home_team')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'guest_team')->textInput(['maxlength' => 32]) ?>

    <?php
    echo
    $form->field($model,'date')->
        widget(DatePicker::className(),
        [
        'name' => 'date_match',
        'clientOptions' => [
            'autoclose'=>true,
            'format' => 'dd-M-yyyy'
        ]
    ])->textInput(['maxlength' => 10]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
