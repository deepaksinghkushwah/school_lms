<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "theme".
 *
 * @property int $id
 * @property string $title
 * @property string $filename
 * @property int $default 0 = not default, 1 = default
 */
class Theme extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'theme';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title','inverse'], 'required'],
            [['default'], 'integer'],
            [['filename'], 'file', 'extensions' => 'css','mimeTypes' => 'text/css'],
            ['filename', 'required', 'on' => 'create', 'skipOnEmpty' => false],
            [['title', 'filename'], 'string', 'max' => 255],
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
            'filename' => 'Filename',
            'default' => 'Default',
            'inverse' => 'Colors'
        ];
    }
    
    public function afterSave($insert, $changedAttributes) {
        
        if($this->default == 1){
            Theme::updateAll(['default' => 0], "id != ".$this->id);
        }
        return parent::afterSave($insert, $changedAttributes);
        
    }
}
