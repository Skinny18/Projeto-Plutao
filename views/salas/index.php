<?php

use app\models\Salas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SalasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'salas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Salas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_sala',
            'nome_sala',
            'capacidade',
            'descricao:ntext',
            'imagem_url:url',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Salas $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_sala' => $model->id_sala]);
                 }
            ],
        ],
    ]); ?>


</div>
