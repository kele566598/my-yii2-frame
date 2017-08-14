<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 2017/8/13
 * Time: 下午7:48
 */

namespace app\modules\admin\controllers;


use app\models\log\AppErrorLog;
use yii\base\Exception;
use yii\web\NotFoundHttpException;

/**
 * 错误记录控制器
 * Class ErrorlogController
 * @package app\modules\admin\controllers
 */
class ErrorlogController extends BaseAdminController
{
    public function actionIndex(){
        $http_code = trim( $this->get("http_code","" ) );
        $ip = trim($this->get('ip'));

        $p = intval( $this->get("p",1) );
        $p = ( $p > 0 )?$p:1;

        $query = AppErrorLog::find();

        if($http_code){
            $query->andWhere(['http_code'=>$http_code]);
        }

        if($ip){
            //[ 'LIKE','ip','%'.strtr($ip,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
            $query->andWhere(['LIKE','ip',$ip]);
        }

        //分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
        //60,60 ~ 11,10 - 1
        $total_res_count = $query->count();
        $total_page = ceil( $total_res_count / $this->page_size );

        $models = $query->orderBy([ 'id' => SORT_DESC ])
            ->offset( ( $p - 1 ) * $this->page_size )
            ->limit($this->page_size)
            ->all( );

        $http_code_list = AppErrorLog::getHttpcodeList();

        return $this->render('index',[
            'search'=>[
                'http_code'=>$http_code,
                'ip'=>$ip,
            ],
            'http_code_list'=>$http_code_list,
            'models'=>$models,
            'pages' => [
                'total_count' => $total_res_count,
                'page_size' => $this->page_size,
                'total_page' => $total_page,
                'p' => $p
            ],
        ]);
    }

    public function actionView(){
        $id = $this->get('id');
        if(!$id){
            throw new NotFoundHttpException('页面未找到~',1);
           // return $this->renderPartial('@app/modules/admin/views/layouts/alert.php');
        }
        $data = AppErrorLog::find()->where(['id'=>$id])->asArray()->one();

        if(!$data){
            throw new NotFoundHttpException('页面未找到~',1);
        }

        return $this->render('view',[
            'data'=>$data,
        ]);
    }
}