<?php
namespace  frontend\widgets\post;


use common\models\PostModel;
use frontend\models\PostForm;
use yii\base\Widget;
use yii\data\Pagination;
use yii\helpers\Url;

class  PostWidget extends  Widget{
    /*
     文章列表标题
     * */
    public $title='';
    /*
     *条数
     * */
    public $limit=2;
   /*
    * 显示更多
    * */
    public $more=true;
    /*
     * 显示分页
     * */
    public $page=true;

    public  function  run(){
        $curPage=\Yii::$app->request->get('page',1);
        $tag=\Yii::$app->request->get("tag");
        //查询条件
        $search=[];
        $cond["is_valid"]=PostModel::IS_VALID;
        if($tag) $search['tag_name']=$tag;
        $res=PostForm::getList($cond,$curPage,$this->limit,$search);
        $result['title']=$this->title?$this->title:"最新文章";
        $result['more']=Url::to(['post/index']);
        $result['body']=$res['data']?:[];
        //是否显示分页
        if($this->page){
            $pages=new Pagination(['totalCount'=>$res['count'],'pageSize'=>$res['pageSize']]);
            $result['page']=$pages;
        }

        return $this->render('index',['data'=>$result]);

    }
}