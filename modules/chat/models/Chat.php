<?php

namespace app\modules\chat\models;

use Yii;
use \app\models\User;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property int $to_user_id
 * @property string|null $message
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $status 0 = deleted, 1=unread, 2=read
 *
 * @property User $toUser
 */
class Chat extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['to_user_id'], 'required'],
            [['to_user_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['message'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['to_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'to_user_id' => 'To User',
            'message' => 'Message',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
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
     * Gets query for [[ToUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getToUser() {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }

}
