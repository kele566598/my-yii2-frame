<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 2017/8/13
 * Time: 下午12:19
 */

namespace app\controllers;

use app\common\components\BaseController;
use app\common\services\applog\ApplogService;
use yii;

/**
 * 统一错误处理控制器
 * Class ErrorController
 * @package app\controllers
 */
class ErrorController extends BaseController
{
    public function actionError(){

        $error = Yii::$app->errorHandler->exception;
        $err_msg = "";
        if ($error) {
            $code = $error->getCode();
            $msg = $error->getMessage();
            $file = $error->getFile();
            $line = $error->getLine();

            $time = microtime(true);

            $err_msg = $msg . " [file: {$file}][line: {$line}][err code:$code.]".
                "[url:{$_SERVER['REQUEST_URI']}][post:".http_build_query($_POST)."]";

            ApplogService::addErrorLog(Yii::$app->id,$err_msg);

            $code = intval($code);
            // 1 来自admin模块的错误，2 group模块的错误，3前台模块的错误
            if( $code==1){
                // 1.来自Admin模块的错误
                $this->layout = '@app/modules/admin/views/layouts/main.php';
                return $this->render("error",['code'=>$code,'msg'=>$msg]);
            } else if($code==2){
                // 2.来自group模块的错误
            } else if($code==3){
                // 3.来自前台模块的错误
            }
        }


        return $this->renderPartial('404');
    }
}