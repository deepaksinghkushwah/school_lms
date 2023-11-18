<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_student_result_main".
 *
 * @property int $id
 * @property int $teacher_id
 * @property int $exam_id
 * @property float $exam_total_score
 * @property string $attempt_id
 * @property int $student_id
 * @property double $score
 * @property string $created_at
 *
 * @property LmsExam $exam
 * @property User $student
 * @property User $teacher
 */
class LmsStudentResultMain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lms_student_result_main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_id', 'exam_id', 'attempt_id', 'student_id','exam_total_score'], 'required'],
            [['teacher_id', 'exam_id', 'student_id'], 'integer'],
            [['score'], 'number'],
            [['created_at'], 'safe'],
            [['attempt_id'], 'string', 'max' => 255],
            [['exam_id'], 'exist', 'skipOnError' => true, 'targetClass' => LmsExam::className(), 'targetAttribute' => ['exam_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['teacher_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'teacher_id' => 'Teacher ID',
            'exam_id' => 'Exam ID',
            'attempt_id' => 'Attempt ID',
            'student_id' => 'Student ID',
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
    public function getStudent()
    {
        return $this->hasOne(User::className(), ['id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(User::className(), ['id' => 'teacher_id']);
    }
}
