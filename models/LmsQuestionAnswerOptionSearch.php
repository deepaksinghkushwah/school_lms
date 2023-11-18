<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LmsQuestionAnswerOption;

/**
 * LmsQuestionAnswerOptionSearch represents the model behind the search form of `app\models\LmsQuestionAnswerOption`.
 */
class LmsQuestionAnswerOptionSearch extends LmsQuestionAnswerOption
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'question_id', 'is_correct_answer'], 'integer'],
            [['answer_text'], 'safe'],
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
        $query = LmsQuestionAnswerOption::find();

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
            'question_id' => $this->question_id,
            'is_correct_answer' => $this->is_correct_answer,
        ]);

        $query->andFilterWhere(['like', 'answer_text', $this->answer_text]);

        return $dataProvider;
    }
}
