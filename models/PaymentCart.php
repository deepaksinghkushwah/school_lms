<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_cart".
 *
 * @property int $id
 * @property int $item_id
 * @property float $item_price
 * @property string $item_title
 * @property int|null $item_qty
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 */
class PaymentCart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_id', 'item_price', 'item_title'], 'required'],
            [['item_id', 'item_qty', 'created_by', 'updated_by'], 'integer'],
            [['item_price'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['item_title'], 'string', 'max' => 255],
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'item_price' => 'Item Price',
            'item_title' => 'Item Title',
            'item_qty' => 'Item Qty',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
