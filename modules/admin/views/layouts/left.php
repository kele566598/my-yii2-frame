<?php
use app\common\services\UrlService;

$controllerId = Yii::$app->controller->id;
?>

<aside class="main-sidebar">

    <section class="sidebar">



        <?= app\widgets\Adminlte\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => '控制面板', 'options' => ['class' => 'header']],
                    ['label' => '错误日志', 'icon' => 'file-code-o', 'active' => in_array($controllerId, ['errorlog', 'order']), 'url' => UrlService::buildAdminUrl('/errorlog/index')],
                    ['label' => '管理员管理', 'icon' => 'dashboard',  'active' => in_array($controllerId, ['admin', 'order']), 'url' => UrlService::buildAdminUrl('/admin/index')],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => 1],
                    [
                        'label' => 'Same tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
