<?php
use yii\helpers\Html;
use app\common\services\UrlService;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">XIN</span><span class="logo-lg">' . Yii::$app->params['groupTitle'] . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li id="logout"><a href="<?= UrlService::buildGroupUrl('/default/logout') ?>">退出</a></li>
            </ul>
        </div>
    </nav>
</header>
