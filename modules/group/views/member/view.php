<?php
use yii\helpers\Html;
use app\common\services\UrlService;

$this->params['tab'] = [
    'member'=>[ 'title'=>'组织用户列表', 'url'=>'/member/index'],
];
?>


<div class="row m-t">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <?= Html::a('<i class="fa fa-pencil"></i> 编辑',UrlService::buildAdminUrl('/member/update',['id'=>$model->id]),['class'=>'btn btn-primary pull-right'])?>
                        <h2>账户信息</h2>
                    </div>
                    <div class="panel-body">
                        <p class="m-t">姓名：<?= Html::encode( $model->nickname )?></p>
                        <p>角色：<?= Html::encode( $model->roleMsg )?></p>
                        <p>手机：<?= Html::encode( $model->mobile )?></p>
                        <p>邮箱：<?= Html::encode( $model->email )?></p>
                    </div>
                </div>
            </div>

        </div>
        <div class="row m-t">
            <div class="col-lg-12">
                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="javascript:void(0);" data-toggle="tab" aria-expanded="false">访问记录</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>访问时间</th>
                                        <th>访问Url</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if( $access_list ):?>
                                        <?php foreach( $access_list as $_item ):?>
                                            <tr>
                                                <td>
                                                    <?=$_item['created_time'];?>
                                                </td>
                                                <td>
                                                    <?=$_item['target_url'];?>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                    <?php else:?>
                                        <tr><td colspan="2">暂无数据...</td></tr>
                                    <?php endif;?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>