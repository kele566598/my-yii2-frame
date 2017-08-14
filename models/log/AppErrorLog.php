<?php

namespace app\models\log;

use Yii;

/**
 * This is the model class for table "app_error_log".
 *
 * @property integer $id
 * @property string $app_name
 * @property string $err_name
 * @property integer $http_code
 * @property integer $err_code
 * @property string $ip
 * @property string $ua
 * @property string $url
 * @property string $content
 * @property string $created_time
 */
class AppErrorLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_error_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'ip', 'ua', 'content'], 'required'],
            [['id', 'http_code', 'err_code'], 'integer'],
            [['content'], 'string'],
            [['created_time'], 'safe'],
            [['app_name'], 'string', 'max' => 30],
            [['err_name'], 'string', 'max' => 50],
            [['ip'], 'string', 'max' => 20],
            [['ua'], 'string', 'max' => 200],
            [['url'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_name' => 'App Name',
            'err_name' => 'Err Name',
            'http_code' => 'Http Code',
            'err_code' => 'Err Code',
            'ip' => 'Ip',
            'ua' => 'Ua',
            'url' => 'Url',
            'content' => 'Content',
            'created_time' => 'Created Time',
        ];
    }

    public static function getHttpcodeList(){
        $sql = 'SELECT http_code,http_code FROM '.self::tableName().' GROUP BY http_code ORDER BY count(*) DESC';

        return Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_KEY_PAIR);


    }
}
