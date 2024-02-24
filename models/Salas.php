<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "salas".
 *
 * @property int $id_sala
 * @property string $nome_sala
 * @property int $capacidade
 * @property string|null $descricao
 * @property string|null $imagem_url
 *
 * @property Reservas[] $reservas
 */
class Salas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'salas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome_sala', 'capacidade'], 'required'],
            [['capacidade'], 'default', 'value' => null],
            [['capacidade'], 'integer'],
            [['descricao'], 'string'],
            [['nome_sala', 'imagem_url'], 'string', 'max' => 255],
            [['id_sala'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_sala' => 'Id Sala',
            'nome_sala' => 'Nome Sala',
            'capacidade' => 'Capacidade',
            'descricao' => 'Descricao',
            'imagem_url' => 'Imagem Url',
        ];
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery|ReservasQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reservas::class, ['id_sala' => 'id_sala']);
    }

    /**
     * {@inheritdoc}
     * @return SalasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SalasQuery(get_called_class());
    }
}
