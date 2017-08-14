<?php
use \yii\helpers\Html;

$i=1;

$this->params['tab'] = [
    'admin'=>[ 'title'=>'管理员列表', 'url'=>'/admin/index'],
];

\app\common\services\StaticService::includeJsStatic('/admin/js/admin/index.js',\app\assets\AdminLteAsset::className());
?>

<div class="row">
    <div class="col-lg-12">

        <form class="form-inline wrap_search">
            <div class="row m-t p-w-m">

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-primary pull-right" href="<?= \app\common\services\UrlService::buildAdminUrl('/admin/add')?>"> <i class="fa fa-plus"></i> 添加管理员 </a>
                </div>
            </div>
        </form>

        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>序号</th>
                <th>用户名</th>
                <th>性别</th>
                <th>邮箱</th>
                <th>状态</th>
                <th>创建时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if (is_null($models)):?>
                <tr><td colspan="7">暂无数据...</td></tr>
            <?php else: ?>
                <?php foreach($models as $model):?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= Html::encode( $model->username )?></td>
                        <td><?= Html::encode( $model->sex )?></td>
                        <td><?= Html::encode( $model->email )?></td>
                        <td><?= Html::encode( $model->status )?></td>
                        <td><?= Html::encode( $model->created_time )?></td>
                        <td>
                            <a href="<?= \app\common\services\UrlService::buildAdminUrl('/errorlog/view',['id'=>$model->id]) ?>">查看</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>


            </tbody>
        </table>
        <?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/pagination.php", [
            'pages' => $pages,
            'url' => '/admin/index',
            'search'=>isset($search)?$search:[],
        ]); ?>
    </div>
</div>