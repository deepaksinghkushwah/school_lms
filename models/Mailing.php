<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mailing".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $subject
 * @property string $message
 * @property int $from_user
 * @property int $to_user
 * @property int $status 0 = unread, 1 = read, 2 = deleted
 * @property string|null $created_at
 *
 * @property User $fromUser
 * @property User $toUser
 */
class Mailing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mailing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'from_user', 'to_user', 'status'], 'integer'],
            [['subject', 'message', 'from_user', 'to_user'], 'required'],
            [['message'], 'string'],
            [['created_at'], 'safe'],
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
            'parent_id' => 'Parent ID',
            'subject' => 'Subject',
            'message' => 'Message',
            'from_user' => 'From User',
            'to_user' => 'To User',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[FromUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user']);
    }

    /**
     * Gets query for [[ToUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user']);
    }
}
