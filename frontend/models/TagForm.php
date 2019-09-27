<?php
namespace frontend\models;

use common\models\TagModel;
use yii\base\Model;
use yii\db\Exception;

class TagForm extends Model{
    public $id;
    public $tags;
    public function rules()
    {
        return [
          ['tags','required'],
          ['tags','each','rule'=>['string']]
        ];
    }
    public function saveTags(){
        $ids=[];
        if(!empty($this->tags)){
            foreach ($this->tags as $tag){
                $ids[]=$this->_saveTag($tag);
            }
        }
        return $ids;
    }
    private function _saveTag($tag){
        $model=new TagModel();
        $res=$model->find()->where(['tag_name'=>$tag])->one();
        if($res){
            $res->updateCounters(['post_num'=>1]);
            return $res->id;
        }else{
            $model->tag_name=$tag;
            $model->post_num=1;
            if(!$model->save()){
                throw new Exception("保存标签失败！");
            }
            return $model->id;
        }
    }
}