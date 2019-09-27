<?php
use yii\helpers\Url;
?>
<!--只言片语-->
<div class="panel-little box-title">
   <span><strong>只言片语</strong></span>
    <span class="pull-right"><a href="#" class="font-12">更多</a></span>
</div>
<div class="panel-body">
    <form action="/" id="w0" method="post">
          <div class="form-group input-group field-feed-content required">
              <textarea name="content" id="feed-content" cols="30" rows="10" class="form-control"></textarea>
              <span class="input-group-btn">
                  <button type="button"  class="btn btn-success btn-feed j-feed" data-url="<?=Url::to(['site/add-feed'])?>">发布</button>
              </span>
          </div>
    </form>
    <?php if(!empty($data['feed'])):?>
    <ul class="media-list media-feed feed-index ps-container ps-active-y">
        <?php foreach ($data['feed'] as $list):?>
        <li class="media">
            <div class="media-left">
                <a href="#" rel="author" class="avatar" data-original-title="" title="">
                    <img  src="<?=Yii::$app->params['avatar']['small'] ?>" alt="">
                </a>
            </div>
            <div class="media-body">
                <div class="media-content"><a href="#" rel="author" data-original-title=""><?=$list['user']['username'].":".$list['content'];?></a></div>
                <div class="media-action"><?=date('Y-m-d h:i:s',$list['created_at'])?></div>
            </div>
        </li>
        <?php endforeach;?>
    </ul>
    <?php endif;?>
</div>
