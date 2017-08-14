<?php
use yii\helpers\Html;

$this->params['tab'] = [
        'errorlog'=>[ 'title'=>'错误日志', 'url'=>'/errorlog/index'],
];
?>
<div class="row">
    <div class="col-lg-12">
        <div class="m-b-md">
            <h2>错误日志信息</h2>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>名称</th>
                <th>数据</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach( $data as $key=>$value):?>
                <tr>
                    <td><?= Html::encode($key)?></td>
                    <td><?= Html::encode($value)?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>