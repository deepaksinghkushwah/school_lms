<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_class_subject_relation".
 *
 * @property int $id
 * @property int $class_id
 * @property int $subject_id
 *
 * @property LmsMasterClass $class
 * @property LmsMasterSubject $subject
 */
class LmsClassSubjectRelation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lms_class_subject_relation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_id', 'subject_id'], 'required'],
            [['class_id', 'subject_id'], 'integer'],
            [['class_id'], 'exist', 'skipOnError' => true, 'targetClass' => LmsMasterClass::className(), 'targetAttribute' => ['class_id' => 'id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => LmsMasterSubject::className(), 'targetAttribute' => ['subject_id' => 'id']],
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
        ];
    }

    /**
     * Gets query for [[Class]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClass()
    {
        return $this->hasOne(LmsMasterClass::className(), ['id' => 'class_id']);
    }

    /**
     * Gets query for [[Subject]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(LmsMasterSubject::className(), ['id' => 'subject_id']);
    }
}
