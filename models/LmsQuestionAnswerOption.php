<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_question_answer_option".
 *
 * @property int $id
 * @property int $question_id
 * @property string $answer_text
 * @property int $is_correct_answer
 *
 * @property LmsQuestionBank $question
 */
class LmsQuestionAnswerOption extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lms_question_answer_option';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_id', 'answer_text'], 'required'],
            [['question_id', 'is_correct_answer'], 'integer'],
            [['answer_text'], 'string'],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => LmsQuestionBank::className(), 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Question ID',
            'answer_text' => 'Answer Text',
            'is_correct_answer' => 'Is Correct Answer',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(LmsQuestionBank::className(), ['id' => 'question_id']);
    }
}
