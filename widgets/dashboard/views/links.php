<?php

use yeesoft\helpers\Html;

/* @var $this yii\web\View */
?>
<div class="post-quick-links text-center">
    <?php foreach ($links as $link) : ?>
        <?= Html::a("<b>{$link['count']}</b> {$link['label']}", $link['url']) ?>
    <?php endforeach; ?>
</div>
<?php
$css = <<<CSS
.box .post-quick-links a{
    padding: 0 5px;
}
CSS;

$this->registerCss($css);
?>