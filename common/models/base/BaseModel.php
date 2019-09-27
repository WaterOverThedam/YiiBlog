<?php
/**
 * Created by PhpStorm.
 * User: Machenike
 * Date: 2019/9/8
 * Time: 18:19
 */
namespace  common\models\base;

use common\tools\SqlTool;
use yii\db\ActiveRecord;
use yii\db\Query;

class BaseModel extends  ActiveRecord{
   public function  getPages(Query $query,$curPage=1,$pageSize=10,$search=null){
          if($search){
              $query=$query->andFilterWhere($search);
          }
          $data['count']=$query->count();

          if(!$data['count']){
              return ['count'=>0,'curPage'=>$curPage,'pageSize'=>$pageSize,'start'=>0,
                     'end'=>0,'data'=>[]
                  ];
          }
          //不规范页码处理
          if(ceil($data['count']/$pageSize)<$curPage) $curPage=ceil($data['count']/$pageSize);
          if($curPage<1) $curPage=1;
          $data['curPage']=$curPage;
          $data['pageSize']=$pageSize;
          //当前页始起文章记录数
          $data['start']=($curPage-1)*$pageSize+1;
          $data['end']=(ceil($data['count']/$pageSize)==$curPage)?$data['count']:$curPage*$pageSize;

          $query=$query
              ->offset(($curPage-1)*$pageSize)
              ->limit($pageSize);
       SqlTool::print_sql($query);

          $data['data']=$query->asArray()
              ->all();
          return $data;
   }
}