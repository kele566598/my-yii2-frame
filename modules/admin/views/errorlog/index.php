<?php
use \yii\helpers\Html;

$i=1;

$this->params['tab'] = [
    'errorlog'=>[ 'title'=>'错误日志', 'url'=>'/errorlog/index'],
];

\app\common\services\StaticService::includeJsStatic('/admin/js/errorlog/index.js',\app\assets\AdminLteAsset::className());
?>

<div class="row">
    <div class="col-lg-12">


        <form class="form-inline wrap_search">
            <div class="row m-t p-w-m">

                <div class="form-group">
                    <select name="http_code" class="form-control inline">
                        <option value="0">请选择HTTP状态码</option>

                        <?php if(!is_null($http_code_list)):?>
                            <?php foreach($http_code_list as $key=>$value):?>
                                <option value="<?=$value?>"  <?php if($key=$search['http_code']) echo 'selected';?>><?=$value?></option>
                            <?php endforeach;?>
                        <?php endif;?>
                    </select>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="ip" placeholder="请输入IP" class="form-control" value="<?=$search['ip']?>">
                        <input type="hidden" name="p" value="1">
                        <span class="input-group-btn">
                  <button type="button" class="btn btn-primary search">
                      <i class="fa fa-search"></i>搜索
                  </button>
            </span>
                    </div>
                </div>
            </div>
            <hr/>

        </form>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>序号</th>
                <th>状态码</th>
                <th>ip</th>
                <th>url</th>
                <th>发生时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($models as $model):?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= Html::encode( $model->http_code )?></td>
                <td><?= Html::encode( $model->ip )?></td>
                <td><?= Html::encode( substr($model->url,0,80) )?></td>
                <td><?= Html::encode( $model->created_time )?></td>
                <td>
                    <a href="<?= \app\common\services\UrlService::buildAdminUrl('/errorlog/view',['id'=>$model->id]) ?>">查看</a>
                </td>
            </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
        <?php echo \Yii::$app->view->renderFile("@app/modules/admin/views/common/pagination.php", [
            'pages' => $pages,
            'url' => '/errorlog/index',
            'search'=>$search,
        ]); ?>
    </div>
</div>