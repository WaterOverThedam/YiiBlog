<?php
/**
 * Created by PhpStorm.
 * User: Machenike
 * Date: 2019/9/14
 * Time: 10:36
 */
namespace  frontend\models;
use common\models\FeedModel;
use yii\base\Model;
use yii\db\Exception;

class  FeedForm extends Model{

    public $content;
    public $_lastError;
    public function rules()
    {
        return [
            ['content','required'],
            ['content','string','max'=>255],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id'=>'ID',
            'content'=>'内容'
        ];
    }
    public function getList(){
        $model=new FeedModel();
        $res=$model->find()->limit(10)->with('user')
            ->orderBy(['id'=>SORT_DESC])
            ->asArray()
            ->all();
        return $res?:[];
    }
    /*
     * 留言墙保存
     * */
    public function  create(){
        try{
           $model= new FeedModel();
           $model->user_id=\Yii::$app->user->identity->getId();
           $model->content=$this->content;
           $model->created_at=time();
           $res=$model->save();
           if(!$res) {
               throw new Exception("保存失败！");
           }
           return true;
        }catch (Exception $e){
           $this->_lastError=$e->getMessage();
           return false;
        }

    }
}