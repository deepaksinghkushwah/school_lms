<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_question_bank".
 *
 * @property int $id
 * @property int $class_id
 * @property int $subject_id
 * @property string $question_text
 * @property double $score_point
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property int $status 0 = inactive, 1 = active
 *
 * @property LmsQuestionAnswerOption[] $lmsQuestionAnswerOptions
 * @property LmsMasterClass $class
 * @property LmsMasterSubject $subject
 */
class LmsQuestionBank extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lms_question_bank';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_id', 'subject_id', 'question_text','score_point'], 'required'],
            [['class_id', 'subject_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['question_text'], 'string'],
            [['score_point'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
            'class_id' => 'Class ID',
            'subject_id' => 'Subject ID',
            'question_text' => 'Question Text',
            'score_point' => 'Score Point',
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
    public function getLmsQuestionAnswerOptions()
    {
        return $this->hasMany(LmsQuestionAnswerOption::className(), ['question_id' => 'id']);
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
}
