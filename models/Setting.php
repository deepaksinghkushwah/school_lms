<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property string $title
 * @property string $key
 * @property string $value
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'key', 'value'], 'required'],
            [['title', 'key', 'value'], 'string', 'max' => 255]
        ];
    }
    
    public function beforeValidate() {
        parent::beforeValidate();
        $fields = [
            'title', 'key', 'value'
        ];
        foreach ($fields as $field) {
            $this->{$field} = strip_tags(\yii\helpers\HtmlPurifier::process($this->{$field}));
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'key' => 'Key',
            'value' => 'Value',
        ];
    }
}
