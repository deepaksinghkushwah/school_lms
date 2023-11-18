<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LmsMailing;

/**
 * LmsMailingSearch represents the model behind the search form of `app\models\LmsMailing`.
 */
class LmsMailingSearch extends LmsMailing
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'from_user', 'to_user'], 'integer'],
            [['subject', 'message'], 'safe'],
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
        $query = LmsMailing::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        
        //exit($this->to_user. " Here");
        
        if($this->status){
            $this->status = is_array($this->status) ? implode(",", $this->status) : $this->status;
            $query->where("status IN (".$this->status.")");
        }
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
            return $dataProvider;
        }
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'from_user' => $this->from_user,
            'to_user' => $this->to_user,            
        ]);
        
        

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'message', $this->message]);
        
        return $dataProvider;
    }
}
