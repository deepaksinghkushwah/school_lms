<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_mailing_attachment".
 *
 * @property int $id
 * @property int $mail_id
 * @property string $filename
 * @property string $file_title
 * @property string $file_type
 *
 * @property LmsMailing $mail
 */
class LmsMailingAttachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lms_mailing_attachment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mail_id', 'filename', 'file_title', 'file_type'], 'required'],
            [['mail_id'], 'integer'],
            [['filename', 'file_title', 'file_type'], 'string', 'max' => 255],
            [['mail_id'], 'exist', 'skipOnError' => true, 'targetClass' => LmsMailing::className(), 'targetAttribute' => ['mail_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mail_id' => 'Mail ID',
            'filename' => 'Filename',
            'file_title' => 'File Title',
            'file_type' => 'File Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMail()
    {
        return $this->hasOne(LmsMailing::className(), ['id' => 'mail_id']);
    }
}
