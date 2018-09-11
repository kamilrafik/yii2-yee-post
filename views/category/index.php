<?php

use yii\widgets\Pjax;
use yeesoft\helpers\Html;
use yeesoft\grid\GridView;
use yeesoft\post\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel yeesoft\post\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('yee/media', 'Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/post', 'Posts'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['actions'] = Html::a(Yii::t('yee', 'Add New'), ['create'], ['class' => 'btn btn-sm btn-primary']);
?>
<div class="box box-primary">
    <div class="box-body">
        <?php $pjax = Pjax::begin() ?>
        <?=
        GridView::widget([
            'pjaxId' => $pjax->id,
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'quickFilters' => false,
            'columns' => [
                ['class' => 'yeesoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px'], 'displayFilter' => false],
                [
                    'class' => 'yeesoft\grid\columns\TitleActionColumn',
                    'controller' => '/post/category',
                    'title' => function (Category $model) {
                        return Html::a($model->title, ['update', 'id' => $model->id], ['data-pjax' => 0]);
                    },
                    'buttonsTemplate' => '{update} {delete}',
                    'filterOptions' => ['colspan' => 2],
                ],
                [
                    'attribute' => 'parent_id',
                    'value' => function (Category $model) {
                        return ($model->parent) ? $model->parent->title : '<span class="not-set">' . Yii::t('yii', '(not set)') . '</span>';
                    },
                    'format' => 'raw',
                    'filter' => Category::getCategories(),
                    'filterInputOptions' => ['class' => 'form-control', 'encodeSpaces' => true],
                    'options' => ['style' => 'width:30%'],
                ],
                [
                    'attribute' => 'description',
                    'options' => ['style' => 'width:30%'],
                ],
                [
                    'class' => 'yeesoft\grid\columns\StatusColumn',
                    'attribute' => 'visible',
                    'options' => ['style' => 'width:80px'],
                ],
            ],
        ])
        ?>
        <?php Pjax::end() ?>
    </div>
</div>