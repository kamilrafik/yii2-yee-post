<?php

namespace yeesoft\post\widgets\dashboard;

use yeesoft\helpers\FA;
use yeesoft\models\User;
use yeesoft\dashboard\widgets\DashboardWidget;
use Yii;

class PostWidget extends DashboardWidget
{

    /**
     * @var integer most recent post limit 
     */
    public $limit = 5;

    /**
     * @var string model class name
     */
    public $modelClass = 'yeesoft\post\models\Post';

    /**
     * @var string search model class name
     */
    public $searchModelClass = 'yeesoft\post\models\search\PostSearch';

    /**
     * @var string index action
     */
    public $indexAction = '/post/default/index';

    /**
     * @var string list view file
     */
    public $indexView = 'index';

    /**
     * @var string list view file
     */
    public $quickLinksView = 'quick-links';

    /**
     * @var array total post options
     */
    public $quickLinksOptions;

    public function init()
    {
        parent::init();
        $this->icon = FA::_PENCIL;
        $this->title = Yii::t('yee/post', 'Posts Activity');
        $this->visible = User::hasPermission('viewPosts');
    }

    public function renderContent()
    {
        $modelClass = $this->modelClass;
        $items = $modelClass::find()->orderBy(['id' => SORT_DESC])->limit($this->limit)->all();
        return $this->render($this->indexView, compact('items'));
    }

    public function renderFooterContent()
    {
        if (!$this->quickLinksOptions) {
            $this->quickLinksOptions = $this->getDefaultQuickLinksOptions();
        }

        $links = [];
        $modelClass = $this->modelClass;
        $searchModelClass = $this->searchModelClass;
        $formName = (new $searchModelClass())->formName();

        foreach ($this->quickLinksOptions as $option) {
            $links[] = [
                'count' => $modelClass::find()->filterWhere($option['filter'])->count(),
                'label' => $option['label'],
                'url' => [$this->indexAction, $formName => $option['filter']],
            ];
        }

        return $this->render($this->quickLinksView, compact('links'));
    }

    public function getDefaultQuickLinksOptions()
    {
        $modelClass = $this->modelClass;
        return [
                ['label' => Yii::t('yee', 'Published'), 'filter' => ['status' => $modelClass::STATUS_PUBLISHED]],
                ['label' => Yii::t('yee', 'Pending'), 'filter' => ['status' => $modelClass::STATUS_PENDING]],
        ];
    }

}
