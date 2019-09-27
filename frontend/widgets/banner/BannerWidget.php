<?php
/**
 * Created by PhpStorm.
 * User: Machenike
 * Date: 2019/9/13
 * Time: 23:37
 */
namespace  frontend\widgets\banner;
use Yii;
use yii\bootstrap\Widget;

class BannerWidget extends Widget{
    public $item=[];
    public function init(){
       if(empty($this->item)){
          $this->item=[
             ['label'=>'demo','image_url'=>'/statics/img/banner/b_0.jpg','url'=>['site/index'],
               'html'=>'','active'=>'active'
                 ],
             ['label'=>'demo','image_url'=>'/statics/img/banner/b_1.jpg','url'=>['site/index'],'html'=>'','active'=>'active'],
             ['label'=>'demo','image_url'=>'/statics/img/banner/b_2.jpg','url'=>['site/index'],'html'=>'','active'=>'active'],
          ];
       }
    }
    public function run(){
        $data['items']=$this->item;
        return $this->render('index',['data'=>$data]);
    }
}