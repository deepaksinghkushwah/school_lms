<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_order".
 *
 * @property int $id
 * @property int $user_id
 * @property float $total_amt
 * @property int $status 0 = unpaid, 1 = paid
 * @property int|null $gateway 0 = payumoney, 1 = offline
 * @property string|null $gateway_response
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 *
 * @property PaymentOrderDetail[] $paymentOrderDetails
 * @property User $user
 */
class PaymentOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'status', 'gateway', 'created_by', 'updated_by'], 'integer'],
            [['total_amt'], 'number'],
            [['gateway_response'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'total_amt' => 'Total Amt',
            'status' => 'Status',
            'gateway' => 'Gateway',
            'gateway_response' => 'Gateway Response',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
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
     * Gets query for [[PaymentOrderDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentOrderDetails()
    {
        return $this->hasMany(PaymentOrderDetail::className(), ['order_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
