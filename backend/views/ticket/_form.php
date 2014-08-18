<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Match;


/**
 * @var yii\web\View $this
 * @var backend\models\Ticket $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="ticket-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'price')->input('number'); ?>

    <?php

    /* select 3 field from all match table */
    $data = Match::find()
            ->select(['id_match', 'home_team','guest_team'])
            ->asArray()
            ->all();

    var_dump($data);

    /* create new array with only interested data, clearing the array */
    $data  = \yii\helpers\ArrayHelper::map($data, 'id_match', 'home_team');

    /* Create my dropDown Menu List */
    echo $form->field($model,'match_id')->dropDownList($data,['prompt' => 'Select Match']);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
