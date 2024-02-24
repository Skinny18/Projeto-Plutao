<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SalasSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="salas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_sala') ?>

    <?= $form->field($model, 'nome_sala') ?>

    <?= $form->field($model, 'capacidade') ?>

    <?= $form->field($model, 'descricao') ?>

    <?= $form->field($model, 'imagem_url') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
