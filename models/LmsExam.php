<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_exam".
 *
 * @property int $id
 * @property string $title
 * @property int $class_id
 * @property int $subject_id
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property int $status 0 = inactive, 1 = active
 *
 * @property LmsMasterClass $class
 * @property LmsMasterSubject $subject
 * @property LmsExamQuestion[] $lmsExamQuestions
 */
class LmsExam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lms_exam';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'class_id', 'subject_id'], 'required'],
            [['class_id', 'subject_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 1000],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => LmsMasterClass::className(), 'targetAttribute' => ['class_id' => 'id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => LmsMasterSubject::className(), 'targetAttribute' => ['subject_id' => 'id']],
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
            'title' => 'Title',
            'class_id' => 'Class',
            'subject_id' => 'Subject',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(LmsMasterClass::className(), ['id' => 'class_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(LmsMasterSubject::className(), ['id' => 'subject_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLmsExamQuestions()
    {
        return $this->hasMany(LmsExamQuestion::className(), ['exam_id' => 'id']);
    }
    
    public function getScore($examId){
        return Yii::$app->db->createCommand("SELECT sum(score_point) as total FROM lms_exam_question WHERE exam_id = $examId")->queryScalar();
    }
    
    public function getStudentScore($attemptId){
        $sql = "SELECT sum(score) as total FROM lms_student_result WHERE attempt_id = '$attemptId'";
        return Yii::$app->db->createCommand($sql)->queryScalar();
    }
}
