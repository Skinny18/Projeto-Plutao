<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Salas $model */

$this->title = 'Update Salas: ' . $model->id_sala;
$this->params['breadcrumbs'][] = ['label' => 'Salas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_sala, 'url' => ['view', 'id_sala' => $model->id_sala]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="salas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
