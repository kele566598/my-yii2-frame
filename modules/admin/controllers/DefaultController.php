<?php

namespace app\modules\admin\controllers;

use app\models\admin\LoginForm;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{

    public $layout = 'main-login.php';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin(){
        $model = new LoginForm();

        if( $model->load( \Yii::$app->request->post() ) && $model->validate() ){
            return 666;
        }

        return $this->render('login',[
            'model'=>$model,
        ]);
    }
}
