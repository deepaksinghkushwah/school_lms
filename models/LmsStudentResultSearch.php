<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LmsStudentResult;

/**
 * LmsStudentResultSearch represents the model behind the search form of `app\models\LmsStudentResult`.
 */
class LmsStudentResultSearch extends LmsStudentResult
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'exam_id', 'student_id', 'question_id', 'answer_id', 'correct_answer_id'], 'integer'],
            [['attempt_id', 'question_text', 'answer_text', 'correct_answer_text', 'created_at'], 'safe'],
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
        $query = LmsStudentResult::find();

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
            'exam_id' => $this->exam_id,
            'student_id' => $this->student_id,
            'question_id' => $this->question_id,
            'answer_id' => $this->answer_id,
            'correct_answer_id' => $this->correct_answer_id,
            'score' => $this->score,
            'DATE(created_at)' => $this->created_at,
        ]);
        $query->groupBy("attempt_id");

        $query->andFilterWhere(['like', 'attempt_id', $this->attempt_id])
            ->andFilterWhere(['like', 'question_text', $this->question_text])
            ->andFilterWhere(['like', 'answer_text', $this->answer_text])
            ->andFilterWhere(['like', 'correct_answer_text', $this->correct_answer_text]);
        //echo $query->createCommand()->rawSql;
        return $dataProvider;
    }
}
