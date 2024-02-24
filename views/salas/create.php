<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Salas $model */

$this->title = 'Create Salas';
$this->params['breadcrumbs'][] = ['label' => 'Salas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
