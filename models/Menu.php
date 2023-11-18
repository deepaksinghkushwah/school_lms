<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $title
 * @property string $location top, left, right, bottom
 * @property int $sort_order
 * @property int $menu_type 1 = dropdown, 2 = list
 * @property int $menu_item_type 1 = indivisual, 2 = category
 * @property int $status 1 = active, 0 = inactive
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'custom_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'location'], 'required'],
            [['sort_order', 'menu_type', 'menu_item_type', 'status'], 'integer'],
            ['sort_order','default','value' => 0],
            [['title', 'location'], 'string', 'max' => 255],
            
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
            'location' => 'Location',
            'sort_order' => 'Sort Order',
            'menu_type' => 'Menu Type',
            'menu_item_type' => 'Menu Item Type',
            'status' => 'Status',
        ];
    }
}
