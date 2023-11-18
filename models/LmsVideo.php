<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_video".
 *
 * @property int $id
 * @property int $class_id
 * @property int $subject_id
 * @property string $title
 * @property string $filename
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 * @property int $status
 *
 * @property LmsMasterClass $class
 * @property LmsMasterSubject $subject
 */
class LmsVideo extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lms_video';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['class_id', 'subject_id', 'title', 'filename'], 'required'],
            [['class_id', 'subject_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at','status'], 'safe'],
            ['status','default','value' => 1],
            [['title', 'filename'], 'string', 'max' => 255],
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
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'class_id' => 'Class',
            'subject_id' => 'Subject',
            'title' => 'Title',
            'filename' => 'Filename',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Class]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClass() {
        return $this->hasOne(LmsMasterClass::className(), ['id' => 'class_id']);
    }

    /**
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubject() {
        return $this->hasOne(LmsMasterSubject::className(), ['id' => 'subject_id']);
    }

}
