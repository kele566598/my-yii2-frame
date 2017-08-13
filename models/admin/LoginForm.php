<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 2017/8/13
 * Time: 下午3:36
 */

namespace app\models\admin;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],

            // 密码 通过 validatePassword() 函数校验
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword(){

    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
        ];
    }
}