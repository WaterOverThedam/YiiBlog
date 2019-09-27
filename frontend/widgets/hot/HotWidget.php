<?php
/**
 * Created by PhpStorm.
 * User: Machenike
 * Date: 2019/9/14
 * Time: 21:30
 */
namespace frontend\widgets\hot;

use common\models\PostExtendModel;
use common\models\PostModel;
use common\tools\SqlTool;
use Yii;
use yii\base\Widget;
use yii\db\Query;

class  HotWidget extends Widget{
    public  $title = '';
    public  $limit = 6;
    public function run()
    {
       $query = (new Query())
           ->select('a.browser,b.id,b.title')
           ->from(['a'=>PostExtendModel::tableName()])
           ->join('LEFT JOIN',['b'=>PostModel::tableName()],'a.post_id = b.id')
           ->where('b.is_valid='.PostModel::IS_VALID)
           ->orderBy(['browser'=>SORT_DESC,'id'=>SORT_DESC]);

       $res = $query->limit($this->limit)->all();
       SqlTool::print_sql($query);
       $result['title'] = $this->title?:'热门浏览';
       $result['body'] = $res?:[];

       return $this->render('index',['data'=>$result]);
    }
}