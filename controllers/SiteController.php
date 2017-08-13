<?php

namespace app\controllers;

use app\common\services\UrlService;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{


    public function actionIndex()
    {

        return UrlService::buildAdminUrl('/user/edit',['id'=>1,'k'=>666]);
        return $this->render('index');
    }


}
