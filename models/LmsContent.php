<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_content".
 *
 * @property int $id
 * @property string $title
 * @property int $class_id
 * @property int $subject_id
 * @property string $content
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property int $status
 *
 * @property LmsMasterClass $class
 * @property LmsMasterSubject $subject
 * @property LmsContentAttachment[] $lmsContentAttachments
 */
class LmsContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lms_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_id', 'subject_id'], 'required'],
            [['class_id', 'subject_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 2000],
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
            'class_id' => 'Class ID',
            'subject_id' => 'Subject ID',
            'content' => 'Content',
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
    public function getLmsContentAttachments()
    {
        return $this->hasMany(LmsContentAttachment::className(), ['content_id' => 'id']);
    }
    
    public function getAuthor(){
        $profile = Userprofile::findOne(['user_id' => $this->created_by]);
        return $profile;
    }
}
