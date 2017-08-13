<?php

// 注释掉这两段，当部署在生产环境
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

/*定义版本号常量*/
if(file_exists(__DIR__.'/ver.txt')){
    $content = trim(file_get_contents( __DIR__.'/ver.txt' ));
    $ver = $content?$content:time();
} else{
    $ver = time();
}
define('RELEASE_VERSION',$ver);

(new yii\web\Application($config))->run();
