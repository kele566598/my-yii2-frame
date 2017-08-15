<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 2017/8/13
 * Time: 下午2:16
 */

namespace app\modules\admin\controllers;

use app\models\admin\Admin;
use Yii;
use app\common\components\BaseController;
use app\common\services\UrlService;
use app\common\services\applog\ApplogService;

class BaseAdminController extends BaseController
{
    public $page_size = 20;
    protected $current_user = null;

    // 无需登录的地址
    public $allowAllAction = [
        'admin/default/login'
    ];

    public function beforeAction( $action ){
        $is_login = $this->checkLoginStatus();

        if ( in_array($action->getUniqueId(), $this->allowAllAction ) ) {
            return true;
        }

        if(!$is_login) {
            if ( \Yii::$app->request->isAjax) {
                $this->renderJSON([], "未登录,请返回用户中心", -302);
            } else {
                $this->redirect( UrlService::buildAdminUrl("/default/login") );
            }
            return false;
        }

        ApplogService::addAdminLog( $this->current_user['id'] );
        return true;
    }

    /**
     * 目的：验证是否当前登录态有效 true or  false
     */

    protected function checkLoginStatus(){

        $auth_cookie = $this->getCookie( Yii::$app->params['admin_auth_token'] );

        if( !$auth_cookie ){
            return false;
        }
        list($auth_token,$id) = explode("#",$auth_cookie);
        if( !$auth_token || !$id ){
            return false;
        }
        if( $id && preg_match("/^\d+$/",$id) ){
            $user_info = Admin::findOne([ 'id' => $id,'status' => 1 ]);
            if( !$user_info ){
                $this->removeAuthToken();
                return false;
            }
            if( $auth_token != $this->geneAuthToken( $user_info ) ){
                $this->removeAuthToken();
                return false;
            }
            $this->current_user = $user_info;
            \Yii::$app->view->params['current_user'] = $user_info;
            return true;
        }
        return false;
    }

    public function setLoginStatus( $user_info ){
        $auth_token = $this->geneAuthToken( $user_info );
        $this->setCookie(Yii::$app->params['admin_auth_token'],$auth_token."#".$user_info['id']);
    }

    protected  function removeAuthToken(){
        $this->removeCookie( Yii::$app->params['admin_auth_token'] );
    }

    //统一生成加密字段 ,加密字符串 = md5( login_name + login_pwd + login_salt )
    public function geneAuthToken( $user_info ){
        return md5( "{$user_info['username']}-{$user_info['password']}-{$user_info['password_salt']}");
    }

    public function getUid(){
        return $this->current_user?$this->current_user['id']:0;
    }

    public function alertSuccess( $msg ){
        Yii::$app->session->setFlash('success', $msg);
    }

    public function alertFail( $msg ){
        Yii::$app->session->setFlash('danger', $msg);
    }

}