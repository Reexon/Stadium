<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\MatchSearch $searchModel
 */

$this->title = 'Matches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="match-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Match', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php var_dump(Yii::$app->request->getQueryParams());?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_match',
            'home_team',
            'guest_team',
            'date',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
