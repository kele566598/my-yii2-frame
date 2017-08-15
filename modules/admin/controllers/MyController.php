<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;

class MyController extends BaseAdminController
{
    public function actionIndex(){

        $model = $this->current_user;

        if(!$model){
            throw new NotFoundHttpException('页面未找到~');
        }

        $model->setScenario('update');
        $password = $model->password;
        $model->load(Yii::$app->request->post());

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->isPost && $model->validate()) {
            if(!empty($model->password)){
                $model->setSalt();
                $model->setPassword($model->password);
            } else {
                $model->password = $password;
            }

            $model->updated_time = date('Y-m-d H:i:s');
            if ($model->save(false)) {
                $this->setLoginStatus($model);
                $this->alertSuccess('修改成功~');
                return $this->redirect(['index']);
            } else {
                $this->alertFail( '修改失败~' );
            }
        }

        $model->password = '';

        return $this->render('form',[
           'model'=>$model,
        ]);
    }

}