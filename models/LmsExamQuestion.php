<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_exam_question".
 *
 * @property int $id
 * @property int $exam_id
 * @property int $question_id
 * @property int $score_point
 * @property int $sort_order
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 *
 * @property LmsExam $exam
 * @property LmsQuestionBank $question
 */
class LmsExamQuestion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lms_exam_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exam_id', 'question_id'], 'required'],
            [['exam_id', 'question_id', 'sort_order', 'created_by', 'updated_by'], 'integer'],
            ['score_point','number'],
            [['created_at', 'updated_at'], 'safe'],
            [['exam_id'], 'exist', 'skipOnError' => true, 'targetClass' => LmsExam::className(), 'targetAttribute' => ['exam_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => LmsQuestionBank::className(), 'targetAttribute' => ['question_id' => 'id']],
        ];
    }
    
    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'value' => date('Y-m-d H:i:s'),
            ],
            [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'value' => Yii::$app->user->id,
            ],
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
            'question_id' => 'Question ID',
            'score_point' => 'Score Point',
            'sort_order' => 'Sort Order',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
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
}
