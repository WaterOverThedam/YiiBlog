<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_extends".
 *
 * @property int $id 自增ID
 * @property int $post_id 文章id
 * @property int $browser 浏览量
 * @property int $collect 收藏量
 * @property int $praise 点赞
 * @property int $comment 评论
 */
class PostExtendModel extends \common\models\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_extends';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'browser', 'collect', 'praise', 'comment'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'post_id' => '文章id',
            'browser' => '浏览量',
            'collect' => '收藏量',
            'praise' => '点赞',
            'comment' => '评论',
        ];
    }
    public function  upCounter($cond,$attribute,$num){
        $counter=$this->findOne($cond);
        if(!$counter){
            $this->setAttributes($cond);
            $this->$attribute=$num;
            $this->save();
        }else{
            $countData[$attribute]=$num;
            $counter->updateCounters($countData); //自动累加的方法
        }
    }
}
