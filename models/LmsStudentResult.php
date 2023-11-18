<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_student_result".
 *
 * @property int $id
 * @property int $exam_id
 * @property int $student_id
 * @property int $question_id
 * @property string $question_text
 * @property float $question_score 
 * @property int $answer_id
 * @property string $answer_text
 * @property int $correct_answer_id
 * @property string $correct_answer_text
 * @property double $score
 * @property string $created_at
 * @property string $attempt_id
 * @property LmsExam $exam
 * @property LmsQuestionBank $question
 */
class LmsStudentResult extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lms_student_result';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exam_id', 'student_id', 'question_id', 'answer_id', 'answer_text', 'correct_answer_id','attempt_id','question_score'], 'required'],
            [['exam_id', 'student_id', 'question_id', 'answer_id', 'correct_answer_id'], 'integer'],
            [['question_text', 'answer_text', 'correct_answer_text'], 'string'],
            [['score'], 'number'],
            [['created_at'], 'safe'],
            [['exam_id'], 'exist', 'skipOnError' => true, 'targetClass' => LmsExam::className(), 'targetAttribute' => ['exam_id' => 'id']],
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
            'exam_id' => 'Exam ID',
            'student_id' => 'Student ID',
            'question_id' => 'Question ID',
            'question_text' => 'Question Text',
            'answer_id' => 'Answer ID',
            'answer_text' => 'Answer Text',
            'correct_answer_id' => 'Correct Answer ID',
            'correct_answer_text' => 'Correct Answer Text',
            'score' => 'Score',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExam()
    {
        return $this->hasOne(LmsExam::className(), ['id' => 'exam_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(LmsQuestionBank::className(), ['id' => 'question_id']);
    }
    /**
     * Total result a student get from an exam
     * @param type $attemptId
     * @return type
     */
    public function getTotal($attemptId){
        return Yii::$app->db->createCommand("SELECT sum(score) as total FROM lms_student_result WHERE attempt_id = :id",[':id' => $attemptId])->queryScalar();
    }
    
    public function getLmsQuestion($questionId, $examId){
        return LmsExamQuestion::findOne(['question_id' => $questionId,'exam_id' => $examId]);
                
    }
}
