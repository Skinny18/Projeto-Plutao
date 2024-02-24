<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reservas".
 *
 * @property int $id_reserva
 * @property int $id_sala
 * @property string $data_hora_inicio
 * @property string $data_hora_fim
 *
 * @property Salas $sala
 */
class Reservas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'data_hora_inicio', 'data_hora_fim', 'nome_representante', 'nome_equipe'], 'required'],
            [['id_reserva', 'id_sala', 'users_id', ], 'integer'],
            [['nome_representante', 'nome_equipe'], 'string'],
            [['data_hora_inicio', 'data_hora_fim'], 'safe'],
            [['id_reserva'], 'unique'],
            [['id_sala'], 'exist', 'skipOnError' => true, 'targetClass' => Salas::class, 'targetAttribute' => ['id_sala' => 'id_sala']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_reserva' => 'Id Reserva',
            'id_sala' => 'Id Sala',
            'data_hora_inicio' => 'Data Hora Inicio',
            'data_hora_fim' => 'Data Hora Fim',
            'nome_representante' => 'Nome do Representante',
            'nome_equipe' => 'Nome da Equipe'
        ];
    }

    /**
     * Gets query for [[Sala]].
     *
     * @return \yii\db\ActiveQuery|SalasQuery
     */
    public function getSala()
    {
        return $this->hasOne(Salas::class, ['id_sala' => 'id_sala']);
    }

    public function verifyExists($id_sala, $dataHoraInicio, $dataHoraFim)
    {
        return $this->find()
            ->where(['id_sala' => $id_sala])
            ->andWhere(['>', 'data_hora_fim', $dataHoraInicio]) 
            ->andWhere(['<', 'data_hora_inicio', $dataHoraFim]) 
            ->exists();
    }

    public function getAllReserve($id_sala){
        return $this->find()->where(['id_sala' => $id_sala])->all();
    }

    public function getAvailable($id_sala)
    {
        $hoursAvailable = [];
        for ($i = 1; $i <= 28; $i++){
            for ($j = 6; $j <= 22; $j++){
                $dataHora = "2024-02-${i} ${j}:00:00";
                $reservado = $this->verifyExists($id_sala, $dataHora, $dataHora);
                if ($reservado == false) {
                    $hoursAvailable[] = $dataHora;
                }
            }
        }
        return $hoursAvailable;
    }


    public function getAvailableForToday($id_sala)
    {
        $hoursAvailable = [];
        $currentDate = date('Y-m-d');
    
        for ($j = 6; $j <= 22; $j++) {
            $dataHora = "{$currentDate} {$j}:00:00";
            $reservado = $this->find()->where(['id_sala' => $id_sala])
            ->andWhere(['<', 'data_hora_fim', $dataHora])  // Verifica se a reserva termina antes do início
            ->andWhere(['>', 'data_hora_inicio', $dataHora])  // Verifica se a reserva começa depois do término
            ->exists();            
            if (!$reservado) {
                $hoursAvailable[] = $dataHora;
            }
        }
    
        return $hoursAvailable;
    }


    public function getLimitForUser($user)
    {
        //Limit per user
        $currentDate = date('Y-m-d');
        $reservasDoUsuario = $this->find()
            ->select(['SUM(EXTRACT(EPOCH FROM (data_hora_fim - data_hora_inicio))/3600)']) // Calcula a diferença em horas
            ->where(['users_id' => $user])
            ->andWhere(['>=', 'data_hora_inicio', $currentDate . ' 00:00:00'])
            ->andWhere(['<=', 'data_hora_fim', $currentDate . ' 23:59:59'])
            ->scalar();
    
        $limiteDiario = 5;
        $horasDisponiveis = $limiteDiario - $reservasDoUsuario;

        return $horasDisponiveis ;

    }

    public function getHoursReserve($user, $data_hora_fim, $data_hora_inicio)
    {
        $timestampFim = strtotime($data_hora_fim);
        $timestampInicio = strtotime($data_hora_inicio);
    
        $diffInSeconds = $timestampFim - $timestampInicio;
        $diffInHours = $diffInSeconds / 3600;
    
        return $diffInHours;
    }



    public function userReserve($id)
    {
        $user = User::findOne(['id' => $id]);
        
        return $user->username;
    }
    

    public function afterSave($insert, $changedAttributes)
    {
        $userId = Yii::$app->user->identity->id;

        $user =  User::findOne(['id' => $userId]);
       
        $user->limite_reservas = $user->limite_reservas - 1;
        
        $user->save();

    }

    public function afterDelete()
    {
        $userId = Yii::$app->user->identity->id;

        $user =  User::findOne(['id' => $userId]);
       
        $user->limite_reservas = $user->limite_reservas + 1;
        
        $user->save();

    }

    public function updateLimit()
    {
        $user = User::find()->all();
        foreach ($users as $user) {
            // Verificar se é o primeiro dia do mês
            $currentDate = date('Y-m-d');
            $firstDayOfMonth = date('Y-m-01');
            
            if ($currentDate == $firstDayOfMonth) {
                // Resetar os limites para o novo mês
                $user->limite_reservas = 30;  
                $user->save();
            }
        }
    }

    /**
     * {@inheritdoc}
     * @return ReservasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReservasQuery(get_called_class());
    }
}
