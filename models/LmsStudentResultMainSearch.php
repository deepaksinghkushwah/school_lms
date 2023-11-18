<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LmsStudentResultMain;

/**
 * LmsStudentResultMainSearch represents the model behind the search form of `app\models\LmsStudentResultMain`.
 */
class LmsStudentResultMainSearch extends LmsStudentResultMain
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'teacher_id', 'exam_id', 'student_id'], 'integer'],
            [['attempt_id', 'created_at'], 'safe'],
            [['score'], 'number'],
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
        $query = LmsStudentResultMain::find();

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
            'teacher_id' => $this->teacher_id,
            'exam_id' => $this->exam_id,
            'student_id' => $this->student_id,
            'score' => $this->score,
            'DATE(created_at)' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'attempt_id', $this->attempt_id]);

        return $dataProvider;
    }
}
