<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Client;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays report.
     *
     * @return string
     */
    public function actionReport($period_days = 10)           
    {
        $firstClient = Client::find()->select(['created'])->where(['status' => Client::STATUS_NEW])->orderBy('created ASC')->limit(1)->one();
        $firstClientTime = $firstClient['created'];
        
        $clientsCount = Client::find()->where(['>', 'created', $firstClientTime])->count();
        
        $interval = date_diff(date_create($firstClientTime), date_create());
        $days_count = $interval->days; // (time() - strtotime($firstClientTime))/(60*60*24)
        $periodsCount = ceil($days_count/$period_days);
        
        $conversion = [0];
        
        for($i=1; $i <= $periodsCount; $i++) {
            $periodClients = Client::find()
                ->where('created <= DATE_ADD(:firstdate, INTERVAL :days DAY)', [':firstdate' => $firstClientTime, ':days' => $period_days*$i])
                ->andWhere(['status' => Client::STATUS_REGISTER])
                ->count();
            
            $conversion[$i] = $periodClients*100/$clientsCount;
        }
        
        return $this->render('report', [
            'conversion' => $conversion,
            'period_days' => $period_days,
            'available_period_days' => [10, 20, 30, 50, 100]
        ]);
    }
    
    public function actionCreateFile()
    {
        return $this->render('create-file');
    }
}
