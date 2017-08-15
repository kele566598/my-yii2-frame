<?php
use app\widgets\Adminlte\Alert;
use app\common\services\UrlService;
?>



<div class="content-wrapper">

    <section class="content-header">
        <div class="col-lg-12">
            <div class="row  border-bottom">
                <div class="col-lg-12">
                    <div class="tab_title">
                        <ul class="nav nav-pills">
                            <?php if( isset($this->params['tab']) ): ?>
                                <?php foreach($this->params['tab'] as $key=>$_tab): ?>
                                    <li <?php if ($key == Yii::$app->controller->id) echo 'class="current"';?>>
                                        <a href="<?= UrlService::buildAdminUrl($_tab['url'])?>"><?= $_tab['title']?></a>
                                    </li>
                                <?php endforeach;?>
                            <?php endif; ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> <?php echo  defined("RELEASE_VERSION")?RELEASE_VERSION:time(); ?>
    </div>
    <strong>Copyright &copy; 2016-<?=date('Y')?> <a href="<?=Yii::$app->params['companyUrl']?>" target="_blank"><?=Yii::$app->params['companyName']?></a>.</strong> All rights
    reserved.
</footer>