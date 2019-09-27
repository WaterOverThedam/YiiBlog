<?php
use frontend\widgets\post\PostWidget;
use yii\base\Widget;
?>
<div class="row">
    <div class="col-lg-9">
        <?=PostWidget::widget(['page'=>1,'limit'=>4]);?>
    </div>
    <div class="col-lg-3">
        <div class="panel">
            <?php if(!Yii::$app->user->isGuest):?>
                <a href="<?= \yii\helpers\Url::to('/post/create'); ?>" class="btn btn-success btn-block btn-post">创建文章</a>
            <?php endif;?>
        </div>
        <!--热门浏览-->
        <?=\frontend\widgets\hot\HotWidget::widget()?>
        <!--标签云-->
        <?=\frontend\widgets\tag\TagWidget::widget()?>
    </div>
</div>