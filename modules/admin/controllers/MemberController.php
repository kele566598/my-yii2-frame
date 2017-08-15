<?php


namespace app\modules\admin\controllers;

use app\models\log\MemberAccessLog;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\models\Member;
use yii\web\NotFoundHttpException;

class MemberController extends BaseAdminController
{
    public function actionIndex(){

        $p = intval( $this->get('p','') );
        $p = ($p>0)?$p:1;

        $query = Member::find();
        $total_count = $query->count();
        $total_page = ceil( $total_count / $this->page_size );

        $models = $query->orderBy('id DESC')
            ->offset( ($p-1) * $this->page_size )
            ->limit( $this->page_size )
            ->all();

        return $this->render('index',[
            'models'=>$models,
            'pages' => [
                'total_count' => $total_count,
                'page_size' => $this->page_size,
                'total_page' => $total_page,
                'p' => $p
            ],
        ]);
    }

    public function actionCreate(){

        $model = new Member();
        $model->setScenario('create');
        $model->load(Yii::$app->request->post());

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->isPost && $model->validate()) {

            $model->setSalt();
            $model->setPassword($model->password);

            $model->created_time = $model->updated_time = date('Y-m-d H:i:s');
            $model->status = Member::STATUS_ACTIVE;
            if ($model->save(false)) {
                $this->alertSuccess('添加成功~');
                return $this->redirect(['index']);
            } else {
                $this->alertFail( '添加失败~' );
            }
        }

        return $this->render('form',[
            'model'=>$model,
        ]);
    }

    public function actionUpdate(){
        $id = $this->get('id');
        if(!$id){
            throw new NotFoundHttpException('页面未找到~');
        }
        $model = Member::findOne($id);
        if(!$model){
            throw new NotFoundHttpException('页面未找到~');
        }

        // 当密码字段不修改时，密码会被置为空，已解决
        $password = $model->password;
        $model->setScenario('update');
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

    public function actionView(){
        $id = $this->get('id');
        if(!$id){
            throw new NotFoundHttpException('页面未找到~');
        }

        $model = Member::findOne($id);
        if(!$model){
            throw new NotFoundHttpException('页面未找到~');
        }

        $access_list = MemberAccessLog::find()->where([ 'uid' => $id ])->orderBy([ 'id' => SORT_DESC ])->limit( 10 )->all();

        return $this->render('view',[
            'model'=>$model,
            'access_list' => $access_list
        ]);
    }

    /**
     * 响应客户端的 锁定、恢复、删除操作
     */
    public function actionOps(){

        if( !\Yii::$app->request->isPost ){
            return $this->renderJSON( [],'操作有误，请重试~~',-1 );
        }

        $id = $this->post('id',[]);
        $act = trim($this->post('act',''));
        if( !$id ){
            return $this->renderJSON([],"请选择要操作的账号~~",-1);
        }

        if( !in_array( $act,['block','recover','delete' ])){
            return $this->renderJSON([],"操作有误，请重试~~",-1);
        }

        $model = Member::find()->where([ 'id' => $id ,'role'=>1])->one();
        if( !$model ){
            return $this->renderJSON([],"指定账号不存在~~",-1);
        }

        if( $act == 'block' ){
            if($model->status == Member::STATUS_ACTIVE){
                $model->status = Member::STATUS_BLOCKED;
                $model->save(false);
            } else {
                return $this->renderJSON([],"只能锁定状态正常的账号~~",-1);
            }
        } else if( $act == 'recover'){
            if( $model->status == Member::STATUS_BLOCKED ){
                $model->status = Member::STATUS_ACTIVE;
                $model->save(false);
            } else {
                return $this->renderJSON([],"只能恢复已锁定的账号~~",-1);
            }
        } else {
            if( $model->status == Member::STATUS_BLOCKED ){
                $model->delete();
            } else {
                return $this->renderJSON([],"只能删除已锁定的账号~~",-1);
            }
        }

        return $this->renderJSON([],'操作成功！',200);
    }

}