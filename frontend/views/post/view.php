<?php

use yii\helpers\Html;

$this->title=$data['title'];
$this->params['breadcrumbs'][]=['label'=>'文章','url'=>['post/index']];
$this->params['breadcrumbs'][]=$this->title;
?>

<div class="row">
    <div class="col-lg-9">
        <div class="page-title">
             <h1><?=$data['title']?></h1>
        </div>
        <span>作者：<?=$data['user_name']?></span>
        <span>发布：<?=date('Y-m-d',$data['created_at']);?></span>
        <span>浏览：<?=isset($data['extend']['browser'])?$data['extend']['browser']:0?> 次</span>
        <div class="page-content">
            <?=$data['content']?>
        </div>

        <div class="page-tag">
          标签：
            <?php foreach ($data['tags'] as $tag):?>
             <span><a href="#"><?=$tag?></a></span>
            <?php endforeach;?>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel">
            <?php if(!Yii::$app->user->isGuest):?>
                <a href="<?= \yii\helpers\Url::to('/post/create'); ?>" class="btn btn-success btn-block btn-post">创建文章</a>
                <?php if(Yii::$app->user->identity->getId()==$data["user_id"]):?>
                    <a href="<?= \yii\helpers\Url::to(['/post/edit','id'=>$data['id']]); ?>" class="btn btn-info btn-block btn-post">编辑文章</a>
                <?php endif;?>
            <?php endif;?>
        </div>
        <!--热门浏览-->
        <?=\frontend\widgets\hot\HotWidget::widget()?>
    </div>
</div>
