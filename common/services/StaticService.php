<?php
namespace app\common\services;

use Yii;

/**
 * 统一静态资源管理 + 加入版本号(防止浏览器缓存，让刚修改的js css代码立即生效)
 * Class StaticService
 * @package app\common\services
 */
class StaticService{

	private static function includeAppStatic($type, $path,$depend){
		$release_version = defined("RELEASE_VERSION")?RELEASE_VERSION:"666";
		$path = $path."?ver={$release_version}";
		if( $type == "css" ){
			Yii::$app->getView()->registerCssFile( $path , [ 'depends' => $depend ]);
		}else{
			Yii::$app->getView()->registerJsFile( $path , [ 'depends' => $depend ]);
		}
	}

    /**
     * 引入js文件
     * @param $path
     * @param $depend
     */
	public static function includeJsStatic($path,$depend){
		self::includeAppStatic("js",$path,$depend);
	}

    /**
     * 引入css文件
     * 例：\app\common\services\StaticService::includeCssStatic('/css/site.css',\app\assets\AppAsset::className());
     * @param $path
     * @param $depend
     */
	public static function includeCssStatic($path,$depend){
		self::includeAppStatic("css",$path,$depend);
	}
}