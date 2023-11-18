<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_master_subject".
 *
 * @property int $id
 * @property string $title
 *
 * @property LmsClassSubject[] $lmsClassSubjects
 */
class LmsMasterSubject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lms_master_subject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLmsClassSubjects()
    {
        return $this->hasMany(LmsClassSubject::className(), ['subject_id' => 'id']);
    }
}
