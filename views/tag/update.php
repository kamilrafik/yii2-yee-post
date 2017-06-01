<?php

/* @var $this yii\web\View */
/* @var $model yeesoft\post\models\Tag */

$this->title = Yii::t('yee/media', 'Update Tag');
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/post', 'Posts'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/post', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('yee', 'Update');
?>

<?= $this->render('_form', compact('model')) ?>