<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var backend\models\Ticket $model
 */

/**
 * @var $match is an array , each position contains information about ticket
 *      but single ticket, correspond to single match, so we use $match[0]
 */
$match = $model->getMatch()->asArray()->all();
$match = $match[0];
var_dump($match);
$team_match = $match['home_team']." - ".$match['guest_team'] ." - (".date('d/m/Y',strtotime($match['date'])).")";

$this->title = $team_match;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_ticket], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_ticket], [
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
            'id_ticket',
            'label',
            'price',
            //'match_id',
           [
                'label' => 'Match',
                'value' => $team_match,
            ],
        ],
    ]) ?>

</div>
