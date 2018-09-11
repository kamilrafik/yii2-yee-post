<?php

namespace yeesoft\post\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yeesoft\db\ActiveRecord;
use yeesoft\behaviors\MultilingualBehavior;
use yeesoft\multilingual\db\MultilingualLabelsTrait;

/**
 * This is the model class for table "post_category".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property integer $visible
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Category extends ActiveRecord
{

    use MultilingualLabelsTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_category}}';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->visible = 1;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['title'], 'required'],
                [['created_by', 'updated_by', 'created_at', 'updated_at', 'visible', 'parent_id'], 'integer'],
                [['description'], 'string'],
                [['slug', 'title'], 'string', 'max' => 255],
                [['slug'], 'unique'],
                ['parent_id', 'exist', 'targetClass' => self::class, 'targetAttribute' => ['parent_id' => 'id']],
                ['parent_id', 'validateParent'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true,
            ],
            'multilingual' => [
                'class' => MultilingualBehavior::className(),
                'languageForeignKey' => 'post_category_id',
                'attributes' => [
                    'title', 'description',
                ]
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yee', 'ID'),
            'slug' => Yii::t('yee', 'Slug'),
            'title' => Yii::t('yee', 'Title'),
            'visible' => Yii::t('yee', 'Visible'),
            'parent_id' => Yii::t('yee', 'Parent Category'),
            'description' => Yii::t('yee', 'Description'),
            'created_by' => Yii::t('yee', 'Created By'),
            'updated_by' => Yii::t('yee', 'Updated By'),
            'created_at' => Yii::t('yee', 'Created'),
            'updated_at' => Yii::t('yee', 'Updated'),
        ];
    }

    public function validateParent($attribute, $params, $validator)
    {
        if (isset($this->id) && $this->$attribute == $this->id) {
            $this->addError($attribute, Yii::t('yee', 'Category cannot be the parent of itself.'));
            return;
        }

        $parent = self::findOne($this->$attribute);

        if ($parent->parent_id) {
            $this->addError($attribute, Yii::t('yee', 'Subcategory cannot be a parent of another category.'));
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['parent_id' => 'id']);
    }

    /**
     * Return all categories.
     *
     * @param bool $asArray
     *
     * @return static[]
     */
    public static function getCategories()
    {
        $result = [];

        $categories = Category::find()->visible()->joinWith('translations')->orderBy(['title' => SORT_ASC])->all();

        $children = [];

        foreach ($categories as $category) {
            if ($category->parent_id) {
                $children[$category->parent_id][] = $category;
            }
        }


        foreach ($categories as $category) {
            if (!$category->parent_id) {
                $result[$category->id] = $category->title;

                if (isset($children[$category->id])) {
                    foreach ($children[$category->id] as $child) {
                        $result[$child->id] = '   ' . $child->title;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @inheritdoc
     * @return \yeesoft\post\models\CategoryQuery
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

}
