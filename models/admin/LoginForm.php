<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 2017/8/13
 * Time: 下午3:36
 */

namespace app\models\admin;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $imgCaptcha;

    public function rules()
    {
        return [
            [['username', 'password','imgCaptcha'], 'required'],
            ['imgCaptcha','validateImgCaptcha'],
            // 密码 通过 validatePassword() 函数校验
            ['password', 'validatePassword'],
        ];
    }

    /**
     * 校验图片验证码
     * @return bool
     */
    public function validateImgCaptcha(){
        $img_captcha_cookie = Yii::$app->request->cookies->getValue(Yii::$app->params['admin_img_captcha_name'],'');
        if(!$img_captcha_cookie){
            $this->addError('imgCaptcha','验证码错误~');
        }
        if(strtolower($img_captcha_cookie) != strtolower($this->imgCaptcha)){
            $this->addError('imgCaptcha','验证码错误~');
        }
        $this->imgCaptcha = '';
        return true;
    }

    public function validatePassword(){
        if (!$this->hasErrors()) {
            $admin = Admin::find()->where(['username'=>$this->username])->one();

            if(!$admin){
                $this->addError('username','用户名或密码错误~');
                return false;
            }

            if(!$admin->validatePassword( $this->password )){
                $this->addError('username','用户名或密码错误~');
                return false;
            }

            if ($admin->status == Admin::STATUS_BLOCKED){
                $this->addError('username','账户已被锁定，请联系管理员~');
                return false;
            }
        }
        return true;

    }



    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'imgCaptcha' => '验证码',
        ];
    }
}