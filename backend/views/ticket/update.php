<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Ticket $model
 */

$this->title = 'Update Ticket: ' . $model->id_ticket;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_ticket, 'url' => ['view', 'id' => $model->id_ticket]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ticket-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
