<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page_attachment".
 *
 * @property string $id
 * @property string $page_id
 * @property string $filename
 *
 * @property Page $page
 */
class PageAttachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_attachment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'filename'], 'required'],
            [['page_id'], 'integer'],
            [['filename'], 'file', 'extensions' => 'png, jpg, doc, docx, xsl, xslx, pdf, txt','mimeTypes' => ['image/png','image/jpg','image/jpeg','text/plain','application/msword','application/vnd.ms-excel','application/pdf','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.openxmlformats-officedocument.wordprocessingml.document']],    
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'filename' => 'Filename',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }
}
