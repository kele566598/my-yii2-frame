<?php

namespace app\controllers;

use Yii;
use app\common\components\BaseController;
use app\common\services\captcha\ValidateCode;

class SiteController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * 生成验证码 + 设置cookie
     * http://xxxx.xin/site/img-captcha
     */
    public function actionImgCaptcha(){
        $font_path = \Yii::$app->getBasePath() ."/web/common/captcha/fonts/captcha.ttf";
        $captcha_handle = new ValidateCode( $font_path );
        $captcha_handle->doimg();
        $this->setCookie( Yii::$app->params['admin_img_captcha_name'],$captcha_handle->getCode() );
    }
}
