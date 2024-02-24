<?php

namespace app\controllers;

use app\models\Salas;
use app\models\Reservas;
use app\models\ReservasSearch;

use Yii;
use app\models\SalasSearch;
use app\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SalasController implements the CRUD actions for Salas model.
 */
class SalasController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ],
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'], // Permite apenas usuários autenticados
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Salas models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SalasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Salas model.
     * @param int $id_sala Id Sala
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_sala)
    {
        $reservaModel = new ReservasSearch();
        $reservas = $reservaModel->getAllReserve($id_sala);
        $data = $reservaModel->getAvailableForToday($id_sala);
        
        return $this->render('view', [
            'model' => $this->findModel($id_sala),
            'reservas' => $reservas,
            'data' => $data
        ]);
    }

    /**
     * Creates a new Salas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Salas();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_sala' => $model->id_sala]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Salas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_sala Id Sala
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_sala)
    {
        $model = $this->findModel($id_sala);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_sala' => $model->id_sala]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Salas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_sala Id Sala
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_sala)
    {
        $this->findModel($id_sala)->delete();

        return $this->redirect(['index']);
    }

    public function ajusteData($data)
    {
        return $data = date('Y-m-d H:i:s', strtotime($data));
    }

    public function actionReservarSala($id_sala)
    {

        $model = new Reservas;
        
      
        $dataHoraInicio = $this->ajusteData($this->request->post('data_hora_inicio')) ; 
        $dataHoraFim = $this->ajusteData($this->request->post('data_hora_fim')); 
        $representante = $this->request->post('nome_representante');
        $equipe = $this->request->post('nome_equipe');

        $existeReserva = $model->verifyExists($id_sala, $dataHoraInicio, $dataHoraFim);

        $userId = Yii::$app->user->identity->id;

        $user = User::findOne(['id' => $userId]);
        $hours = $model->getHoursReserve($userId, $dataHoraFim, $dataHoraInicio);

        if($user->limite_reservas > 0 && $model->getLimitForUser($userId) >= $hours ){
            if (!$existeReserva) {
                $model->id_sala = $id_sala;
                $model->data_hora_inicio = $dataHoraInicio;
                $model->data_hora_fim = $dataHoraFim;
                $model->nome_representante = $representante;
                $model->nome_equipe = $equipe;
                $model->users_id = $userId;
    
                
    
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Reserva criada com sucesso.');
                } else {
                    Yii::$app->session->setFlash('error', 'Erro ao criar reserva.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Já existe uma reserva para este horário.');
            }
        }else{
            Yii::$app->session->setFlash('error', 'Limites de Reservas do Mês/Dia excedido! ');
        }
        
        $reservaModel = new ReservasSearch();

        return $this->render('view', [
            'model' => $this->findModel($id_sala),
            'reservas' => $reservaModel->find()->where(['id_sala' => $id_sala])->all(),
        ]);
    }
    



    /**
     * Finds the Salas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_sala Id Sala
     * @return Salas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_sala)
    {
        if (($model = Salas::findOne(['id_sala' => $id_sala])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
