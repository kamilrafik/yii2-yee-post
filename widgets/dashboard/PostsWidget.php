<?php

namespace yeesoft\post\widgets\dashboard;

use yeesoft\helpers\FA;
use yeesoft\models\User;
use yeesoft\post\models\Post;
use yeesoft\post\models\search\PostSearch;
use yeesoft\dashboard\widgets\DashboardWidget;
use Yii;

class PostsWidget extends DashboardWidget
{

    /**
     * Most recent post limit
     */
    public $limit = 5;

    /**
     * Post index action
     */
    public $indexAction = '/post/default/index';

    /**
     * Total post options
     *
     * @var array
     */
    public $quickLinkOptions;

    public function init()
    {
        parent::init();
        $this->icon = FA::_PENCIL;
        $this->title = Yii::t('yee/post', 'Posts Activity');
        $this->visible = User::hasPermission('viewPosts');
    }

    public function renderContent()
    {
        $posts = Post::find()->orderBy(['id' => SORT_DESC])->limit($this->limit)->all();
        return $this->render('posts', compact('posts'));
    }

    public function renderFooterContent()
    {
        if (!$this->quickLinkOptions) {
            $this->quickLinkOptions = $this->getDefaultQuickLinkOptions();
        }

        $links = [];
        $searchModel = new PostSearch();
        $formName = $searchModel->formName();

        foreach ($this->quickLinkOptions as $option) {
            $links[] = [
                'count' => Post::find()->filterWhere($option['filter'])->count(),
                'label' => $option['label'],
                'url' => [$this->indexAction, $formName => $option['filter']],
            ];
        }

        return $this->render('links', compact('links'));
    }

    public function getDefaultQuickLinkOptions()
    {
        return [
                ['label' => Yii::t('yee', 'Published'), 'filter' => ['status' => Post::STATUS_PUBLISHED]],
                ['label' => Yii::t('yee', 'Pending'), 'filter' => ['status' => Post::STATUS_PENDING]],
        ];
    }

}
