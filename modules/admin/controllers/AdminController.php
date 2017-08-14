<?php


namespace app\modules\admin\controllers;



use app\models\admin\Admin;
use yii\web\NotFoundHttpException;

class AdminController extends BaseAdminController
{
    public function actionIndex(){

        $p = intval( $this->get('p','') );
        $p = ($p>0)?$p:1;

        $query = Admin::find();
        $total_count = $query->count();
        $total_page = ceil( $total_count / $this->page_size );

        $models = $query->offset( ($p-1) * $this->page_size )->limit( $this->page_size )->all();

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

    public function actionAdd(){

        throw new NotFoundHttpException('页面未找到~',610);

        return $this->render('add',[

        ]);
    }

}