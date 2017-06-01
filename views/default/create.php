<?php

/* @var $this yii\web\View */
/* @var $model yeesoft\post\models\Post */

$this->title = Yii::t('yee', 'Create {item}', ['item' => Yii::t('yee/post', 'Post')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', compact('model')) ?>