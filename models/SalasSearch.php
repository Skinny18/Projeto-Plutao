<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Salas;

/**
 * SalasSearch represents the model behind the search form of `app\models\Salas`.
 */
class SalasSearch extends Salas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sala', 'capacidade'], 'integer'],
            [['nome_sala', 'descricao', 'imagem_url'], 'safe'],
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
        $query = Salas::find();

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
            'id_sala' => $this->id_sala,
            'capacidade' => $this->capacidade,
        ]);

        $query->andFilterWhere(['ilike', 'nome_sala', $this->nome_sala])
            ->andFilterWhere(['ilike', 'descricao', $this->descricao])
            ->andFilterWhere(['ilike', 'imagem_url', $this->imagem_url]);

        return $dataProvider;
    }
}
