<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Reservas $model */

$this->title = $model->id_reserva;
$this->params['breadcrumbs'][] = ['label' => 'Reservas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reservas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_reserva' => $model->id_reserva], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_reserva' => $model->id_reserva], [
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
            'id_reserva',
            'id_sala',
            'data_hora_inicio',
            'data_hora_fim',
        ],
    ]) ?>

</div>
