<?php

use frontend\widgets\banner\BannerWidget;
use yii\base\Widget;

/* @var $this yii\web\View */

$this->title = '博客－首页';
?>

<div class="row">
    <div class="col-lg-9">
    <?/*=BannerWidget::widget()*/?>
        <?= \yii\bootstrap\Carousel::widget([
            'items' => [
                [
                    // 必要的，轮播的内容（HTML），比如一个图像标签
                    'content' => '<img src="/statics/img/banner/b_0.jpg"/>',
                    // 可选的，该轮播标题（HTML）
                    'caption' => "<h4>别让这些闹心的套路阻碍了你的思路</h4>",
                    // 可选的，轮播样式
                    'options' => [],
                ],
                [
                    // 必要的，轮播的内容（HTML），比如一个图像标签
                    'content' => '<img src="/statics/img/banner/b_1.jpg"/>',
                    // 可选的，该轮播标题（HTML）
                    'caption' => "<h4>别让这些闹心的套路阻碍了你的思路</h4>",
                    // 可选的，轮播样式
                    'options' => [],
                ],
                [
                    // 必要的，轮播的内容（HTML），比如一个图像标签
                    'content' => '<img src="/statics/img/banner/b_2.jpg"/>',
                    // 可选的，该轮播标题（HTML）
                    'caption' => "<h4>别让这些闹心的套路阻碍了你的思路</h4>",
                    // 可选的，轮播样式
                    'options' => [],
                ]
            ]
        ])?>
   <!--文章列表-->
    <?=\frontend\widgets\post\PostWidget::widget()?>
    </div>
    <div class="col-lg-3">
        <!--留言-->
        <?=\frontend\widgets\chat\ChatWidget::widget()?>
        <!--热门浏览-->
        <?=\frontend\widgets\hot\HotWidget::widget()?>
        <!--标签云-->
        <?=\frontend\widgets\tag\TagWidget::widget()?>
    </div>

</div>
