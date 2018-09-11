<?php

namespace yeesoft\post\models;

use Yii;
use yii\base\Model;
use yeesoft\data\ActiveDataProvider;

/**
 * CategorySearch represents the model behind the search form about `yeesoft\post\models\Category`.
 */
class CategorySearch extends Category
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'visible', 'created_by', 'updated_by', 'parent_id'], 'integer'],
            [['slug', 'title', 'description', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->visible = null;
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Category::find()->joinWith('translations');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'visible' => $this->visible,
            'parent_id' => $this->parent_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ])
        ->andFilterWhere(['like', 'slug', $this->slug])
                ->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

}
