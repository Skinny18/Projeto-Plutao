<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use yii\authclient\OAuthToken;
use app\models\ContactForm;
use Firebase\JWT\JWT;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    // ...
    
    private function generateJwtToken($username)
    {
        $key = 'your-secret-key';
        $token = [
            'username' => $username,
            'iat' => time(),            // Tempo em que o token foi emitido (emitido agora)
            'exp' => time() + 3600,     // Tempo de expiração do token (1 hora a partir de agora)
        ];
        return JWT::encode($token, $key, 'HS256');
        }
    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $model = new User();
        return $this->render('index', ['model' => $model]);
    }

    public function actionCreate()
    {
        $model = new User();
       
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) ) {
                $hash = Yii::$app->getSecurity()->generatePasswordHash($model->password_hash);
                $model->username = $model->username;
                $model->password_hash = $hash;
                $model->auth_key = $this->generateJwtToken($model->username);        
                $model->save();
                return $this->render('create', ['model' => $model]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', ['model' => $model]);
    

    
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            // var_dump()
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goBack();
        }

        $model->password_hash = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
