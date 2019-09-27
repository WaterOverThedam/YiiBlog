<?php

use yii\helpers\Url;
$url=\Yii::$app->request->getBaseUrl();
?>
<div class="panel-title box-title">
    <span><strong><?=$data['title']?></strong></span>
    </div>
<div class="panel-body padding-left-0">
    <div class="tag-cloud">
        <?php foreach ($data['body'] as $list):?>
		<a href="<?=Url::to([$url,'tag'=>$list['tag_name']])?>"><?=$list['tag_name']?></a>
		<?php endforeach;?>
    </div>
</div>