 <?php
use yii\helpers\Url;
?><div id="myCarousel" class="carousel slide">
    <!-- 轮播（Carousel）指标 -->
    <ol class="carousel-indicators">
        <?php foreach ($data['items'] as $k=>$list):?>
            <li data-target="#myCarousel" data-slide-to=<?=$k ?> class="<?=$list['active']?>"></li>
        <?php endforeach;?>
    </ol>

     <!--wrapper for slides -->
    <div class="carousel-inner home-banner" role="listbox">
       <?php foreach ($data['items'] as $k=>$list):?>
       <div class="item <?=(isset($list['active']) && $list['active'])? 'active':'' ?>">
         <a href="<?=Url::to($list['url'])?>"><img src="<?=$list['image_url']?>" alt="<?=$list['label']?>">
         <div class="carousel-caption">
             <?=$list['html']?>
         </div>
         </a>
       </div>
       <?php endforeach;?>

        <!--control-->
        <a href="#carousel-example-generic" class="left carousel-control" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">《</span>
        </a>
        <a href="#carousel-example-generic" class="left carousel-control" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">》</span>
        </a>

