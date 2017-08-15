<?php

namespace app\modules\group\controllers;

use app\common\services\UrlService;
use app\models\group\LoginForm;
use app\models\Member;

/**
 * Default controller for the `group` module
 */
class DefaultController extends BaseGroupController
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
            $member = Member::find()->where(['username'=>$model->username])->one();
            $this->setLoginStatus( $member );
            return $this->redirect( UrlService::buildGroupUrl('/default/index') );
        }

        return $this->render('login',[
            'model'=>$model,
        ]);
    }

    public function actionLogout(){
        $this->removeAuthToken();
        return $this->redirect( UrlService::buildGroupUrl('/default/login' ));
    }
}
