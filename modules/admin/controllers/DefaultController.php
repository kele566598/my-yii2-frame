<?php

namespace app\modules\admin\controllers;

use app\common\services\UrlService;
use app\models\admin\Admin;
use app\models\admin\LoginForm;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends BaseAdminController
{

    public $layout = 'main.php';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin(){
        $this->layout = 'main-login.php';

        $model = new LoginForm();

        if( $model->load( \Yii::$app->request->post() ) && $model->validate() ){
            $admin = Admin::find()->where(['username'=>$model->username])->one();
            $this->setLoginStatus( $admin );
            return $this->redirect( UrlService::buildAdminUrl('/default/index') );
        }

        return $this->render('login',[
            'model'=>$model,
        ]);
    }

    public function actionLogout(){
        $this->removeAuthToken();
        return $this->redirect( UrlService::buildAdminUrl('/default/login' ));
    }
}
