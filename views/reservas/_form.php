<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Reservas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reservas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_reserva')->textInput() ?>

    <?= $form->field($model, 'id_sala')->textInput() ?>

    <?= $form->field($model, 'data_hora_inicio')->textInput() ?>

    <?= $form->field($model, 'data_hora_fim')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
