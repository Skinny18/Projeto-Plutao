<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reservas;

/**
 * ReservasSearch represents the model behind the search form of `app\models\Reservas`.
 */
class ReservasSearch extends Reservas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_reserva', 'id_sala'], 'integer'],
            [['nome_representante', 'nome_equipe'], 'string'],
            [['data_hora_inicio', 'data_hora_fim'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Reservas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_reserva' => $this->id_reserva,
            'id_sala' => $this->id_sala,
            'data_hora_inicio' => $this->data_hora_inicio,
            'data_hora_fim' => $this->data_hora_fim,
            'nome_representante' => $this->nome_representante,
            'nome_equipe' => $this->nome_equipe
        ]);

        return $dataProvider;
    }

    public function searchByUserId($params)
    {
        $query = Reservas::find()->where(['users_id' => $params]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_reserva' => $this->id_reserva,
            'id_sala' => $this->id_sala,
            'data_hora_inicio' => $this->data_hora_inicio,
            'data_hora_fim' => $this->data_hora_fim,
            'nome_representante' => $this->nome_representante,
            'nome_equipe' => $this->nome_equipe
        ]);

        return $dataProvider;
    }

}
