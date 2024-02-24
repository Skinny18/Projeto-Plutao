<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Salas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="salas-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'nome_sala')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'capacidade')->textInput() ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'imagem_url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
