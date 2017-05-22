<?php

namespace yeesoft\post\widgets\dashboard;

use yeesoft\helpers\FA;
use yeesoft\models\User;
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
        return User::hasPermission('viewPosts');
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
        return 1234;
    }

    public function getProgress()
    {
        return 75;
    }

    public function getDescription()
    {
        return '61% Increase in 30 Days';
    }

}
