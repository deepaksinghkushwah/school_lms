<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_order_detail".
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $item_type 1 = course
 * @property int $item_id
 * @property string $item_title
 * @property int|null $item_qty 0 = unpaid, 1 = paid
 * @property float $item_price
 * @property float $total_amt
 *
 * @property PaymentOrder $order
 */
class PaymentOrderDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_order_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'item_id', 'item_title'], 'required'],
            [['order_id', 'item_type', 'item_id', 'item_qty'], 'integer'],
            [['item_price', 'total_amt'], 'number'],
            [['item_title'], 'string', 'max' => 255],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentOrder::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'item_type' => 'Item Type',
            'item_id' => 'Item ID',
            'item_title' => 'Item Title',
            'item_qty' => 'Item Qty',
            'item_price' => 'Item Price',
            'total_amt' => 'Total Amt',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(PaymentOrder::className(), ['id' => 'order_id']);
    }
}
