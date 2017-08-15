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

                    ['label' => '组织用户管理', 'icon' => 'fa fa-user',  'active' => in_array($controllerId, ['member']), 'url' => UrlService::buildGroupUrl('/member/index')],
                    ['label' => '账户设置', 'icon' => 'fa fa-cog',  'active' => in_array($controllerId, ['my']), 'url' => UrlService::buildGroupUrl('/my/index')],
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
