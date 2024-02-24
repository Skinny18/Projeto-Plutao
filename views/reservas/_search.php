<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ReservasSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reservas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_reserva') ?>

    <?= $form->field($model, 'id_sala') ?>

    <?= $form->field($model, 'data_hora_inicio') ?>

    <?= $form->field($model, 'data_hora_fim') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
