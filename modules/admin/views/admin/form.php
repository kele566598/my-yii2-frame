<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\admin\Admin;

$this->params['tab'] = [
    'admin'=>[ 'title'=>'管理员列表', 'url'=>'/admin/index'],
];

$this->title = $model->isNewRecord ? '添加管理员' : '编辑管理员账户';

$fieldOptions1 = [

    'options' => ['class' => 'form-group has-feedback'],
    'template' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>{error}"
];

$option = [
    'labelOptions' => ['class' => 'col-lg-2 control-label'],
    'template' => '{label}<div class="col-lg-10">{input}{hint}{error}</div>',
];
?>

    <div class="row m-t  wrap_account_set">
        <div class="col-lg-12">
            <h2 class="text-center"><?=$this->title?></h2>

            <?php $form = ActiveForm::begin([
                'enableAjaxValidation' => false,
                'options' => ['autocomplete' => 'off','class'=>'form-horizontal m-t m-b']
            ]); ?>

            <?= $form->field($model, 'username', $option)->textInput(['autocomplete' => 'off','disabled'=>$model->isNewRecord ? false:true]) ?>
            <?= $form->field($model, 'password', $option)->passwordInput(['autocomplete' => 'off']) ?>
            <?= $form->field($model, 'email', $option)->input('email') ?>
            <?= $form->field($model, 'nickname', $option) ?>
            <?= $form->field($model, 'gender', $option)->dropDownList(Admin::getGenderList()) ?>
            <?= $form->field($model, 'mobile', $option) ?>

            <div class="form-group">
                <div class="col-lg-4 col-lg-offset-2">
                <?= Html::resetButton('<i class="fa fa-repeat"></i> 重置', ['class' => 'btn btn-default']) ?>
                <?= Html::submitButton('<i class="fa fa-floppy-o"></i> 提交', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>


        </div>
    </div>



<?php
$css = <<<CSS
div.required label:before {
    content: " *";
    color: red;
}
CSS;

$this->registerCss($css);