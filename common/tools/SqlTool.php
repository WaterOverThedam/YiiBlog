<?php
namespace common\tools;
use yii\db\Query;

/**
 * Created by PhpStorm.
 * User: Machenike
 * Date: 2019/9/14
 * Time: 22:14
 */
class SqlTool{

    public static function print_sql(Query $query, $path="e:/logs/"){
        if(!is_dir($path))
            throw new \yii\base\Exception("sql打印目录不存在！");

        $sql=$query->createCommand()->getRawSql();
        file_put_contents($path.'sql_'.date('Y-m-d').'.txt', "Time: ".date('Y-m-d H:i:s')."  ".var_export($sql,true)."\r\n", FILE_APPEND);
    }
}