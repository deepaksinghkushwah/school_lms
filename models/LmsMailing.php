<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_mailing".
 *
 * @property int $id
 * @property string $subject
 * @property string $message
 * @property int $from_user
 * @property int $to_user
 * @property int $status 0 = unread, 1 = read, 2 = deleted
 *
 * @property User $fromUser
 * @property User $toUser
 * @property LmsMailingAttachment[] $lmsMailingAttachments
 */
class LmsMailing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lms_mailing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'message', 'from_user', 'to_user','parent_id'], 'required'],
            [['message'], 'string'],
            [['from_user','parent_id', 'status'], 'integer'],
            ['parent_id','default','value' => 0],
            [['subject'], 'string', 'max' => 1000],
            [['from_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_user' => 'id']],
            [['to_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_user' => 'id']],
        ];
    }
    
    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'created_at',
                'value' => date('Y-m-d H:i:s'),
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
            'subject' => 'Subject',
            'message' => 'Message',
            'from_user' => 'From User',
            'to_user' => 'To User',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLmsMailingAttachments()
    {
        return $this->hasMany(LmsMailingAttachment::className(), ['mail_id' => 'id']);
    }
}
