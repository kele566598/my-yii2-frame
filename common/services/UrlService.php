<?php
namespace  app\common\services;

use yii\helpers\Url;

/**
 * 构建网址的服务。目的：网址统一管理，所有网址都是用包含域名的绝对路径
 * Class UrlService
 * @package app\common\services
 */
class UrlService {


	public static function buildMUrl( $path,$params = [] ){
		$domain_config = \Yii::$app->params['domain'];
		$path = Url::toRoute(array_merge([ $path ],$params));
		return $domain_config['m'] .$path;
	}

    /**
     * 构建管理员模块的地址
     * 举例：UrlService::buildAdminUrl('/user/edit',['id'=>1,'k'=>666]);
     * 输出：http://my-yii2-frame.xin/admin/user/edit?id=1&k=666
     * @param $path
     * @param array $params
     * @return string
     */
	public static function buildAdminUrl( $path,$params = [] ){
		$domain_config = \Yii::$app->params['domain'];
		$path = Url::toRoute(array_merge([ $path ],$params));
		return $domain_config['admin'] .$path;
	}

    public static function buildGroupUrl( $path,$params = [] ){
        $domain_config = \Yii::$app->params['domain'];
        $path = Url::toRoute(array_merge([ $path ],$params));
        return $domain_config['group'] .$path;
    }

    /**
     * 根地址
     * @param $path
     * @param array $params
     * @return string
     */
	public static function buildWwwUrl( $path,$params = [] ){
		$domain_config = \Yii::$app->params['domain'];
		$path = Url::toRoute(array_merge([ $path ],$params));
		return $domain_config['www'].$path;
	}

    /**
     * 不想a标签有跳转，用这个
     * @return string
     */
	public static function buildNullUrl(){
		return "javascript:void(0);";
	}


	public static function buildPicUrl( $bucket,$file_key ){
		$domain_config = \Yii::$app->params['domain'];
		$upload_config = \Yii::$app->params['upload'];
		return $domain_config['www'].$upload_config[ $bucket ]."/".$file_key;
	}
}