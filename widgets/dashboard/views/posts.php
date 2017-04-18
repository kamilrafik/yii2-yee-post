<?php

use yeesoft\helpers\Html;

/* @var $this yii\web\View */
?>

<?php if (count($posts)): ?>
    <?php foreach ($posts as $post) : ?>
        <div class="post clearfix">
            <h4><?= Html::a(Html::encode($post->title), ['/post/default/view', 'id' => $post->id]) ?></h4>
            <div class="post-content">
                <?= Html::encode($post->shortContent); ?>
            </div>
            <div class="post-footer">
                <div class="pull-left">
                    <b>Author: </b><?= Html::a($post->author->username, ['/user/default/update', 'id' => $post->author->id]) ?>
                </div>
                <div class="pull-right">
                    <?= $post->publishedDate ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <h4><em><?= Yii::t('yee/post', 'No posts found.') ?></em></h4>
<?php endif; ?>


<?php
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