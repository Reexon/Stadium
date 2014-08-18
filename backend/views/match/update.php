<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Match $model
 */

$this->title = 'Update Match: ' . $model->home_team . " - ". $model->guest_team;
$this->params['breadcrumbs'][] = ['label' => 'Matches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_match, 'url' => ['view', 'id' => $model->id_match]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="match-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
