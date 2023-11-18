<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_media".
 *
 * @property int $id
 * @property string $file_title
 * @property string $file_name
 * @property string $file_type
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class Media extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lms_media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_title', 'file_type'], 'required'],
            
            [['file_name'], 'file', 'extensions' => 'gif, jpg, jpeg, png','mimeTypes' => 'image/*'],
            ['file_name', 'required', 'on' => 'create', 'skipOnEmpty' => false],
            
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by'], 'integer'],
            [['file_title'], 'string', 'max' => 1000],
            [['file_name', 'file_type'], 'string', 'max' => 255],
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
            'file_title' => 'File Title',
            'file_name' => 'File Name',
            'file_type' => 'File Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
