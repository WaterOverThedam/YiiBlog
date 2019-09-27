<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title ='创建';
$this->params['breadcrumbs'][]=['label'=>'文章','url'=>['post/index']];
$this->params['breadcrumbs'][]=$this->title;
?>

<div class="row">
    <div class="col-lg-9">
        <div class="panel-title box-title"><span>创建文章</span></div>
        <div class="pane-body">
            <?php $form=ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']])?>
            <?=$form->field($model,'title')->textinput(['maxlength'=>true])?>
            <?=$form->field($model,'cat_id')->dropDownList($cat)?>
            <?=$form->field($model,'label_img',['inputOptions'=>[]])->widget(\Ycn\Qiniu\UploadWidget::class,['options'=>[
                'domain' => Yii::$app->params['qiniu']['domain'].'/'
            ]]) ?>
            <?=$form->field($model,'content')->widget('kucha\ueditor\UEditor',[
                'clientOptions' => [
                    //编辑区域大小
                    'initialFrameHeight' => '200',
                    //设置语言
                    'lang' => 'zh-cn', //中文为 zh-cn
                    //定制菜单
                    'toolbars' => [
                        [
                            'fullscreen', 'source', 'undo', 'redo', '|',
                            'fontsize',
                            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                            'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                            'forecolor', 'backcolor', '|',
                            'lineheight', '|',
                            'indent', '|',
                           // 'simpleupload', //单图上传
                            'insertimage', //多图上传
                        ],
                    ]
                ]
            ])?>
            <?=$form->field($model,'tags')->widget('common\widgets\tags\TagWidget')?>
            <div class="form-group">
                <?=Html::submitButton("发布",['class'=>'btn btn-success'])?>
            </div>
            <?php $form::end()?>
        </div>
    </div>
    <div class="col-lg-3">
         <div class="panel-title box-title">
             <span>注意事项</span>
         </div>
         <div class="panel-body">
             <p>222</p>
             <p>333</p>
         </div>
    </div>
</div>
