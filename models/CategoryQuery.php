<?php

namespace yeesoft\post\models;

use yeesoft\multilingual\db\MultilingualTrait;


/**
 * This is the ActiveQuery class for [[Post]].
 *
 * @see Post
 */
class CategoryQuery extends \yii\db\ActiveQuery
{

    use MultilingualTrait;

    /**
     * @inheritdoc
     * @return Post[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Post|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
    public function visible()
    {
        return $this->andWhere(['visible' => 1]);
    }

}
