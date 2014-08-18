<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/**
 * @var yii\web\View $this
 * @var backend\models\Payment $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ticket_id')->textInput() ?>

    <?php /*$form->field($model,'date')->
        widget(DatePicker::className(),
            [
                'name' => 'date_ticket',
                'clientOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd-M-yyyy'
                ]
            ])->textInput(['maxlength' => 10]);*/
    ?>
    <?= $form->field($model, 'qty')->input('number') ?>

    <?php

    $users = \backend\models\User::find()
            ->select(['id','username'])
            ->asArray()
            ->all();

    /* create new array with only interested data, clearing the array */
    $users  = \yii\helpers\ArrayHelper::map($users, 'id', 'username');

    echo $form->field($model, 'user_id')->dropDownList($users); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
