<?php

use app\models\Reservas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ReservasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Suas Reservas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservas-user">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <h3>Você tem disponível: <?=  $limite; ?> reservas</h3>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'data_hora_inicio',
            'data_hora_fim',
            'nome_representante',
            'nome_equipe',
            [
                'attribute' => 'user_id',
                'value' => fn ($model) => $model->userReserve($model->users_id),
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Reservas $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_reserva' => $model->id_reserva]);
                 }
            ],
        ],
    ]); ?>


</div>
