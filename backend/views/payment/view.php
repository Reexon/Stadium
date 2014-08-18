<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var backend\models\Payment $model
 * @var backend\models\Ticket $ticket
 */

$this->title = $model->id_payment;
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_payment], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_payment], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_payment',
            'ticket_id',
            [
                'label' =>'Match',
                'value' => $model->ticket->match->home_team." vs ".$model->ticket->match->guest_team
            ],
            [
                'label' => 'Type',
                'value' => $model->ticket->label
            ],
            'date',
            'qty',
            [
                'label' => 'Total',
                'value' => $model->qty*$model->ticket->price
            ],
        ],
    ]) ?>

</div>
