<?php

use yii\jui\DatePicker;
use yeesoft\helpers\Html;
use yeesoft\models\User;
use yeesoft\post\models\Post;
use yeesoft\post\models\Tag;
use yeesoft\post\models\Category;
use yeesoft\widgets\ActiveForm;
use yeesoft\media\widgets\TinyMce;
use yeesoft\post\widgets\MagicSuggest;

/* @var $this yii\web\View */
/* @var $model yeesoft\post\models\Post */
/* @var $form yeesoft\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin() ?>

<div class="row">
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-body">

                <?= $form->languageSwitcher($model) ?>

                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'slug')->slugInput(['maxlength' => true], 'title') ?>

                <?= $form->field($model, 'tagValues')->widget(MagicSuggest::className(), ['items' => Tag::getTags()]); ?>

                <?= $form->field($model, 'content')->widget(TinyMce::className()) ?>

            </div>
        </div>
    </div>


    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body">

                <?php if (!$model->isNewRecord): ?>
                    <?= $form->field($model, 'createdDatetime')->value() ?>

                    <?= $form->field($model, 'updatedDatetime')->value() ?>

                    <?= $form->field($model, 'updatedByName')->value() ?>
                <?php endif; ?>

                <div class="row">
                    <?php if ($model->isNewRecord): ?>
                        <div class="col-md-6">
                            <?= Html::submitButton(Yii::t('yee', 'Create'), ['class' => 'btn btn-primary btn-block']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= Html::a(Yii::t('yee', 'Cancel'), ['index'], ['class' => 'btn btn-default btn-block']) ?>
                        </div>
                    <?php else: ?>
                        <div class="col-md-6">
                            <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary btn-block']) ?>
                        </div>
                        <div class="col-md-6">
                            <?=
                            Html::a(Yii::t('yee', 'Delete'), ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-default btn-block',
                                'data' => [
                                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ])
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-body">
                <?= $form->field($model, 'category_id')->dropDownList(Category::getCategories(), ['prompt' => '', 'encodeSpaces' => true]) ?>

                <?= $form->field($model, 'published_at')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]) ?>

                <?= $form->field($model, 'status')->dropDownList(Post::getStatusList()) ?>

                <?php if (!$model->isNewRecord): ?>
                    <?= $form->field($model, 'created_by')->dropDownList(User::getUsersList()) ?>
                <?php endif; ?>

                <?= $form->field($model, 'comment_status')->dropDownList(Post::getCommentStatusList()) ?>

                <?= $form->field($model, 'view')->dropDownList($this->context->module->viewList) ?>

                <?= $form->field($model, 'layout')->dropDownList($this->context->module->layoutList) ?>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-body">
                <?=
                $form->field($model, 'thumbnail')->widget(yeesoft\media\widgets\FileInput::className(), [
                    'name' => 'image',
                    'buttonTag' => 'button',
                    'buttonName' => Yii::t('yee', 'Browse'),
                    'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                    'options' => ['class' => 'form-control'],
                    'template' => '<div class="post-thumbnail thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                    'thumb' => $this->context->module->thumbnailSize,
                    'imageContainer' => '.post-thumbnail',
                    'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                    'callbackBeforeInsert' => 'function(e, data) {$(".post-thumbnail").show();}',
                ])
                ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


<?php
$css = <<<CSS
.ms-ctn .ms-sel-ctn {
    margin-left: -6px;
    margin-top: -2px;
}
.ms-ctn .ms-sel-item {
    color: #666;
    font-size: 14px;
    cursor: default;
    border: 1px solid #ccc;
}
CSS;

$js = <<<JS
    var thumbnail = $("#post-thumbnail").val();
    if(thumbnail.length == 0){
        $('.post-thumbnail').hide();
    } else {
        $('.post-thumbnail').html('<img src="' + thumbnail + '" />');
    }
JS;

$this->registerCss($css);
$this->registerJs($js, yii\web\View::POS_READY);
?>