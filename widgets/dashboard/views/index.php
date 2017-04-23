<?php

use yeesoft\helpers\Html;

/* @var $this yii\web\View */

$css = <<<CSS
.box .post {
    border-bottom: 1px solid #eee;
    padding: 0 10px 10px 10px;
}
.box .post h4 {
    font-size: 1.15em;
    font-weight: bold;
}
.box .post .post-content {
    text-align: justify;
    margin: 10px 0 5px 0;
}
.box .post .post-footer {
    font-size: 1.1em;
    font-weight: bold;
}
CSS;

$this->registerCss($css);
?>

<?php if (count($items)): ?>
    <?php foreach ($items as $item) : ?>
        <div class="post clearfix">
            <h4><?= Html::a(Html::encode($item->title), ['/post/default/view', 'id' => $item->id]) ?></h4>
            <div class="post-content">
                <?= Html::encode($item->shortContent); ?>
            </div>
            <div class="post-footer">
                <div class="pull-left">
                    <b>Author: </b><?= Html::a($item->author->username, ['/user/default/update', 'id' => $item->author->id]) ?>
                </div>
                <div class="pull-right">
                    <?= $item->publishedDate ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <h4><em><?= Yii::t('yee/post', 'No posts found.') ?></em></h4>
<?php endif; ?>