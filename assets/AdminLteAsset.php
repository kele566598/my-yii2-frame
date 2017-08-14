<?php

namespace app\assets;

use app\common\services\UrlService;
use yii\web\AssetBundle;


class AdminLteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [];

    public $js = [];

    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

    public function registerAssetFiles( $view ){

        //加一个版本号,目的 ： 是浏览器获取最新的css 和 js 文件
        $release_version = defined("RELEASE_VERSION")?RELEASE_VERSION:time();
        $this->css = [
            UrlService::buildWwwUrl( "/common/plugins/bootstrap/css/bootstrap.min.css" ),
            UrlService::buildWwwUrl( "/common/plugins/font-awesome/css/font-awesome.css"),
            UrlService::buildWwwUrl( "/common/plugins/adminlte/css/AdminLTE.min.css"),
            UrlService::buildWwwUrl( "/common/plugins/adminlte/css/skin-blue.min.css"),
            UrlService::buildWwwUrl( "/common/plugins/font-awesome/css/font-awesome.css"),
            UrlService::buildWwwUrl( "/admin/css/style.css",[ 'ver' => $release_version ] )
        ];
        $this->js = [
            //UrlService::buildWwwUrl( "/common/plugins/jQuery/jquery-2.2.3.min.js"),
            UrlService::buildWwwUrl( "/common/plugins/bootstrap/js/bootstrap.min.js"),
            UrlService::buildWwwUrl( "/common/plugins/layer/layer.js"),
            UrlService::buildWwwUrl( "/admin/js/app.js",[ 'ver' => $release_version ] ),
            UrlService::buildWwwUrl( "/admin/js/common.js",[ 'ver' => $release_version ] ),
        ];
        parent::registerAssetFiles( $view );
    }
}
