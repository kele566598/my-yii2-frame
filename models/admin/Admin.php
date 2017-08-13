<?php

namespace app\models\admin;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $password_salt
 * @property string $nickname
 * @property integer $sex
 * @property integer $status
 * @property string $email
 * @property string $mobile
 * @property string $created_time
 * @property string $updated_time
 */
class Admin extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = '1';
    const STATUS_BLOCKED = '0';

    const GENDER_MALE = '1';
    const GENDER_WOMAN = '2';
    const GENDER_SECRET = '0';

    public $password;

    private static $_statusList;
    private static $_genderList;

    public static function tableName()
    {
        return 'admin';
    }

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 4, 'max' => 20],
            ['username', 'match', 'pattern' => '/^[A-Za-z_-][A-Za-z0-9_-]+$/'],
            ['username', 'unique', 'message' => '该用户名已被使用'],

            ['nickname', 'filter', 'filter' => 'trim'],
            ['nickname', 'required'],
            ['nickname', 'string', 'min' => 2, 'max' => 20],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],

            [['password'], 'required'],
            [['password'], 'string', 'min' => 6, 'max' => 24],
            [['password'], 'match', 'pattern' => '/^\S+$/'],

            ['gender', 'default', 'value' => self::GENDER_SECRET],
            ['gender', 'in', 'range' => [self::GENDER_MALE, self::GENDER_WOMAN, self::GENDER_SECRET]],

            ['mobile', 'required'],
            ['mobile', 'match', 'pattern' => '/^1[3|4|5|7|8][0-9]{9}$/'],
        ];
    }

    public function scenarios()
    {
        return [
            'view' => ['username', 'password'],
            ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '登录密码',
            'password_salt' => '登录密码的随机加密秘钥',
            'nickname' => '昵称',
            'sex' => '性别',
            'status' => '状态',
            'email' => '邮箱',
            'mobile' => '手机',
            'created_time' => '插入时间',
            'updated_time' => '更新时间',
        ];
    }

    public static function getGenderList()
    {
        if (self::$_genderList === null) {
            self::$_genderList = [
                self::GENDER_MALE => '男',
                self::GENDER_WOMAN => '女',
                self::GENDER_OTHER => '保密'
            ];
        }

        return self::$_genderList;
    }

    public function getGenderMsg()
    {
        $list = self::getGenderList();

        return isset($list[$this->gender]) ? $list[$this->gender] : null;
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
