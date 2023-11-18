<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_master_content_type".
 *
 * @property int $id
 * @property string $title
 *
 * @property LmsContent[] $lmsContents
 */
class LmsMasterContentType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lms_master_content_type';
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
    public function getLmsContents()
    {
        return $this->hasMany(LmsContent::className(), ['content_type_id' => 'id']);
    }
}
