<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_content_attachment".
 *
 * @property int $id
 * @property int $content_id
 * @property string $filename
 * @property string $file_title
 * @property string $file_type
 *
 * @property LmsContent $content
 */
class LmsContentAttachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lms_content_attachment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'filename', 'file_title', 'file_type'], 'required'],
            [['content_id'], 'integer'],
            [['filename', 'file_title', 'file_type'], 'string', 'max' => 255],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => LmsContent::className(), 'targetAttribute' => ['content_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content_id' => 'Content ID',
            'filename' => 'Filename',
            'file_title' => 'File Title',
            'file_type' => 'File Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(LmsContent::className(), ['id' => 'content_id']);
    }
}
