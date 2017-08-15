<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $password_salt
 * @property string $nickname
 * @property integer $gender
 * @property integer $status
 * @property integer $role
 * @property string $email
 * @property string $mobile
 * @property string $created_time
 * @property string $updated_time
 */
class Member extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = '1';
    const STATUS_BLOCKED = '0';

    const GENDER_MALE = '1';
    const GENDER_WOMAN = '2';
    const GENDER_SECRET = '0';

    const ROLE_USER = '1';  //组织用户
    const ROLE_ADMIN = '9'; //组织管理员

    private static $_statusList = null;
    private static $_genderList = null;
    private static $_roleList = null;


    public static function tableName()
    {
        return 'member';
    }

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 4, 'max' => 20],
            ['username', 'match', 'pattern' => '/^[A-Za-z_-][A-Za-z0-9_-]+$/','message'=>'用户名必需以字母或下划线开头~'],
            ['username', 'unique', 'message' => '该用户名已被使用'],

            ['nickname', 'filter', 'filter' => 'trim'],
            ['nickname', 'required'],
            ['nickname', 'string', 'min' => 2, 'max' => 20],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],

            ['password', 'filter', 'filter' => 'trim'],
            ['password', 'required','on'=>'create'],
            ['password', 'string', 'min' => 6, 'max' => 24],
            ['password', 'match', 'pattern' => '/^\S+$/'],

            ['gender', 'default', 'value' => self::GENDER_SECRET],
            ['gender', 'in', 'range' => [self::GENDER_MALE, self::GENDER_WOMAN, self::GENDER_SECRET]],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [ self::STATUS_ACTIVE, self::STATUS_BLOCKED ]],

            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => [ self::ROLE_USER, self::ROLE_ADMIN ]],

            ['mobile', 'filter', 'filter' => 'trim'],
            ['mobile', 'required'],
            ['mobile', 'match', 'pattern' => '/^1[3|4|5|7|8][0-9]{9}$/','message'=>'手机号格式不正确~'],
        ];
    }

    public function scenarios()
    {
        return [
            'create' => ['username','password','nickname','gender','email','mobile','role'],
            'update'=> ['password','nickname','email','gender','mobile','role'],
            'status'=>['status'],
        ];
    }

    /**
     * 设置密码
     * @param $password
     */
    public function setPassword( $password ) {

        $this->password = $this->getSaltPassword($password);
    }

    /**
     * 设置密码随机加密秘钥
     * @param int $length
     */
    public function setSalt( $length = 16 ){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
        $salt = '';
        for ( $i = 0; $i < $length; $i++ ){
            $salt .= $chars[ mt_rand(0, strlen($chars) - 1) ];
        }
        $this->password_salt = $salt;
    }

    /**
     * 生成加密密码
     * @param $password
     * @return string
     */
    public function getSaltPassword($password) {
        return md5( $password.md5( $this->password_salt ) );
    }

    /**
     * 验证密码
     * @param $password
     * @return bool
     */
    public function validatePassword($password) {
        return $this->password == $this->getSaltPassword($password);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '登录密码',
            'password_salt' => '登录密码的随机加密秘钥',
            'nickname' => '昵称',
            'gender' => '性别',
            'status' => '状态',
            'email' => '邮箱',
            'mobile' => '手机',
            'role' => '角色',
            'created_time' => '添加时间',
            'updated_time' => '更新时间',
        ];
    }

    public static function getGenderList()
    {
        if (self::$_genderList === null) {
            self::$_genderList = [
                self::GENDER_SECRET => '保密',
                self::GENDER_MALE => '男',
                self::GENDER_WOMAN => '女',
            ];
        }

        return self::$_genderList;
    }

    public function getGenderMsg()
    {
        $list = self::getGenderList();

        return isset($list[$this->gender]) ? $list[$this->gender] : null;
    }

    public static function getRoleList(){
        if( self::$_roleList == null ){
            self::$_roleList = [
                '9'=>'组织管理员',
                '1'=>'组织用户',
            ];
        }
        return self::$_roleList;
    }

    public function getRoleMsg(){
        $list = self::getRoleList();

        return isset($list[$this->role]) ? $list[$this->role] : null;
    }

    public static function getStatusList()
    {
        if (self::$_statusList === null) {
            self::$_statusList = [
                self::STATUS_ACTIVE => '正常',
                self::STATUS_BLOCKED => '禁用'
            ];
        }

        return self::$_statusList;
    }

    public function getStatusMsg()
    {
        $list = self::getStatusList();

        return isset($list[$this->status]) ? $list[$this->status] : null;
    }
}
