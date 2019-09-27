<?php
namespace frontend\models;

use common\models\PostModel;
use common\models\RelationPostTagModel;
use common\models\TagModel;
use common\tools\SqlTool;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\db\Query;


class PostForm extends Model {

    public  $id;
    public  $title;
    public  $content;
    public  $label_img;
    public  $label_img_small;
    public  $cat_id;
    public  $tags;

    public $_lastError="";
    /*场景*/
    const SCENARIOS_CREATE='create';
    const SCENARIOS_UPDATE='update';
    /*事件*/
    const EVENT_AFTER_CREATE="eventAfterCreate";
    const EVENT_AFTER_UPDATE="eventAfterUpdate";
    public function  scenarios()
    {
        $scenarios=[
            self::SCENARIOS_CREATE=>['title','content','label_img','label_img_small','cat_id','tags'],
            self::SCENARIOS_UPDATE=>['title','content','label_img','label_img_small','cat_id','tags'],
        ];
        return array_merge(parent::scenarios(),$scenarios);
    }

    //form的rule仅用于界面提示
    public function rules(){
        return [
            [['id','title','content','cat_id'],'required'],
            [['id','cat_id'],'integer'],
            ['title','string','min'=>4,'max'=>50]
        ];
    }
    public function  attributeLabels()
    {
       return [
         'id'=>'编码',
         'title'=>'标题',
         'content'=>'内容',
         'label_img'=>'标签图',
         'label_img_small'=>'缩略图',
         'tags'=>'标签',
         'cat_id'=>'分类'
       ];
    }
    /*
     * 文章创建
     * */
    public function create(){
        //事务
        $transaction=Yii::$app->db->beginTransaction();
        try {
            $model=new PostModel();
            //echo json_encode($model->attributes);die();
            $model->setAttributes($this->attributes,true); //model加入form的数据
            $model->summary=$this->_getSummary();
            $model->user_id=Yii::$app->user->identity->id;
            $model->user_name=Yii::$app->user->identity->username;
            $model->is_valid=PostModel::IS_VALID;
            $model->created_at=time();
            $model->updated_at=time();
            if(!$model->save()){
                throw  new Exception("文章保存失败！");
            }
            $this->id=$model->id;

            $data=array_merge($this->getAttributes(),$model->getAttributes());
            //调用事件(观察者模式)
            $this->_eventAfterCreate($data);
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            $this->_lastError=$e->getMessage();
            return false;
        }
    }
    private function _getSummary($s=0,$e=90,$char='utf-8'){
        if(empty($this->content)) return null;
        return (mb_substr(str_replace('&nbsp;','',strip_tags($this->content)),$s,$e,$char));
    }
    public function getViewById($id){
        //.表示后面是后一层关联（关联层级）
        $res = PostModel::find()->with('relate.tag','extend')->where(['id'=>$id])->asArray()->one();
        if(!$res){
            throw new Exception("文章不存在！");
        }
        $res['tags']=[];
        if(!empty($res['relate'])){
            foreach ($res['relate'] as $list){
                $res['tags'][]=$list['tag']['tag_name'];
            }
        }
        unset($res['relate']);
        //var_dump($res);
        return $res;
    }
    /*
     * 创建完成后，调用事件方法
     * */
    public function _eventAfterCreate($data){
        //添加事件
         $this->on(self::EVENT_AFTER_CREATE,[$this,'_eventAddTag'],$data);
         //触发事件
         $this->trigger(self::EVENT_AFTER_CREATE);
    }
    public function _eventAddTag($event){
         //保存标签
         $tag=new TagForm();
         $tag->tags=$event->data['tags'];
         $tagids=$tag->saveTags();
         //删除原先的关系关系
         RelationPostTagModel::deleteAll(['post_id'=>$event->data['id']]);

         //批量保存文章和标签的关联关系
        if(!empty($tagids)){
            foreach ($tagids as $k=>$id){
                $row[$k]['post_id']=$this->id;
                $row[$k]['tag-id']=$id;
            }
            $res=(new Query())->createCommand()
                ->batchInsert(RelationPostTagModel::tableName(),['post_id','tag_id'],$row)
                ->execute();
            if(!$res){
                throw new Exception("关联关系保存失败");
            }
        }
    }
    public static function getList($cond,$curPage=1,$pageSize=5,$search,$orderBy=['id'=>SORT_DESC]){
        $model = new PostModel();
        $select=['p.id','title','summary','label_img','label_img_small','cat_id','user_id','user_name',
           'is_valid','created_at','updated_at'
        ];
        $query=$model->find()->select($select)->alias("p")->innerJoin('(select 1 x)x',$cond)
            ->leftJoin(RelationPostTagModel::tableName()." r",'p.id=r.post_id')
            ->leftJoin(TagModel::tableName()." t",'r.tag_id=t.id')
            ->with('extend')

            ->orderBy($orderBy); //仅是sql;后面继续分类
        //SqlTool::print_sql($query);
        //分页
        $res=$model->getPages($query,$curPage,$pageSize,$search);

        //格式化
        $res['data']=self::_formatList($res['data']);
        return $res;
    }

    public static  function _formatList($data){ //主要针对标签格式
        foreach ($data as &$list){
            $list['tags']=[];
            if(isset($list['relate'])&&!empty($list['relate'])){
               foreach ($list['relate'] as $l){
                   $list['tags'][]=$l['tag']['tag_name'];
               }
            }
            unset($list['relate']);
        }
        return $data;
    }

}