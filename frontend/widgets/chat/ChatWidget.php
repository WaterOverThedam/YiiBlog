<?php
/**
 * Created by PhpStorm.
 * User: Machenike
 * Date: 2019/9/14
 * Time: 12:19
 */
namespace frontend\widgets\chat;
use frontend\models\FeedForm;
use Yii;
use yii\base\Widget;

class ChatWidget extends Widget{
    public function run(){
        $feed= new FeedForm();
        $data['feed']=$feed->getList();
        return $this->render('index',['data'=>$data]);

    }
}
