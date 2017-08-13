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
        }

        return $this->render("error",[
            "err_msg" => $err_msg
        ]);
    }
}