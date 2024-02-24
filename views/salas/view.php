<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\ReservasSearch;
use yii\grid\GridView;
/** @var yii\web\View $this */
/** @var app\models\Salas $model */

$this->title = $model->nome_sala;
$this->params['breadcrumbs'][] = ['label' => 'Salas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="salas-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id_sala' => $model->id_sala], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_sala' => $model->id_sala], [
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
            'id_sala',
            'nome_sala',
            'capacidade',
            'descricao:ntext',
            'imagem_url:url',
        ],
    ]) ?> 
<!-- <table class="table">
<thead>
    <tr>
        <th>#</th>
        <th>Item</th>
    </tr>
</thead>
<tbody>
    <?php foreach ($data as $index => $item): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= $item ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table> -->
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Reservar Sala
</button>
<?php
$reserva;
foreach ($reservas as $reserva) {
    echo DetailView::widget([
        'model' => $reserva,
        'attributes' => [
            'id_reserva',
            'id_sala',
            'data_hora_inicio:datetime',
            'data_hora_fim:datetime',
            'nome_representante',
            'nome_equipe'
            // outras propriedades, se houver
        ],
    ]);
}
?>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?= Html::beginForm(['reservar-sala', 'id_sala' => $model->id_sala], 'post', ['class' => 'form-control']) ?>
          <!-- Adicione os campos necessários -->
          <label>Data e Hora de Início</label>
          <input class="form-control"  name="data_hora_inicio" required>

          <label>Data e Hora de Fim</label>
          <input  class="form-control" name="data_hora_fim" required>
          <label>Nome do Representante</label>
          <input class="form-control" name="nome_representante" required>
          <label>Nome da Equipe</label>
          <input class="form-control" name="nome_equipe" required>


          <button type="submit" class="btn btn-secondary form-control mt-2" data-bs-dismiss="modal">Reservar</button>
        <?= Html::endForm() ?>
      </div>
      
    </div>
  </div>
</div>


</div>
