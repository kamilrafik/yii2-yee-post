<?php

namespace yeesoft\post\widgets\dashboard;

use yii\db\Query;
use yeesoft\helpers\FA;
use yeesoft\models\User;
use yeesoft\post\models\Post;
use yeesoft\dashboard\widgets\InfoBox;
use Yii;

class PostInfoBox extends InfoBox
{

    /**
     * @var string model class name
     */
    public $modelClass = 'yeesoft\post\models\Post';

    public function getHasAccess()
    {
        return Yii::$app->user->can('view-posts');
    }

    public function getTitle()
    {
        return Yii::t('yee/post', 'Posts');
    }

    public function getIcon()
    {
        return FA::_PENCIL;
    }

    public function getNumber()
    {
        return Post::getDb()->cache(function ($db) {
                    return Post::find()->count();
                });
    }

    public function getProgress()
    {
        return ($this->increase > 100);
    }

    public function getDescription()
    {
        $increase = sprintf("%+d", $this->increase);
        return Yii::t('yee', '{increase}% in 30 Days', ['increase' => $increase]);
    }

    public function getIncrease()
    {
        return Yii::$app->cache->getOrSet([self::className(), 'increase'], function() {
                    $result = (new Query)->select([
                                'SUM(IF(created_at BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND UNIX_TIMESTAMP(), 1, 0)) current',
                                'SUM(IF(created_at BETWEEN UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 2 MONTH)) AND UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 MONTH)), 1, 0)) past'
                            ])->from(Post::tableName())
                            ->one();

                    $increase = ($result['past'] == 0) ? 1 : (($result['current'] / $result['past']) - 1);

                    return 100 * $increase;
                }, 60);
    }

}
