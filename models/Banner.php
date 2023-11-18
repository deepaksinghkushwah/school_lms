<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property string $id
 * @property string $image
 * @property string $heading
 * @property string $subheading
 * @property string $link
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image'], 'file', 'extensions' => 'gif, jpg, jpeg, png'],
            ['image', 'required', 'on' => 'create', 'skipOnEmpty' => false],
            ['status', 'required'],
            [['link'],'url'],
            [['image', 'heading', 'subheading', 'link'], 'string', 'max' => 255],
        ];
    }
    
    public function beforeValidate() {
        parent::beforeValidate();
        $fields = [
            'heading', 'subheading', 
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
            'image' => 'Image',
            'heading' => 'Heading',
            'subheading' => 'Subheading',
            'link' => 'Link',
        ];
    }
}
