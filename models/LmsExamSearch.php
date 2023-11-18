<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LmsExam;

/**
 * LmsExamSearch represents the model behind the search form of `app\models\LmsExam`.
 */
class LmsExamSearch extends LmsExam
{
    /**
     * {@inheritdoc}
     */
    public $classesIds;
    public function rules()
    {
        return [
            [['id', 'class_id', 'subject_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['title', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = LmsExam::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'class_id' => $this->class_id,
            'subject_id' => $this->subject_id,
            'DATE(created_at)' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);
        if(is_array($this->classesIds)){
            $query->andFilterWhere(['in', 'class_id', $this->classesIds]);
        }
        

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
