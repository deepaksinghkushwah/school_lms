<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LmsContent;

/**
 * LmsContentSearch represents the model behind the search form of `app\models\LmsContent`.
 */
class LmsContentSearch extends LmsContent {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['id', 'class_id', 'created_by','subject_id', 'updated_by', 'status'], 'integer'],
                [['title', 'content', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = LmsContent::find();

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
        //var_dump($this->subject_id);exit;
        
        
        if ($this->subject_id == "") {
            $subjects = [];
            $classSubjects = LmsClassSubjectRelation::findAll(['class_id' => $this->class_id]);            
            if ($classSubjects) {
                foreach ($classSubjects as $row) {
                    $subjects[] = $row->subject_id;
                }
            }
            
            $query->andFilterWhere(["in", "subject_id", $subjects]);
        } else {                 
            $query->andFilterWhere(["subject_id" => $this->subject_id]);
        }

        

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'class_id' => $this->class_id,
            //'subject_id' => $this->subject_id,
            'DATE(created_at)' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'content', $this->content]);

        //echo "<pre>";echo $query->createCommand()->rawSql;echo "</pre>";
        return $dataProvider;
    }

}
