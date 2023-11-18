<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page_category".
 *
 * @property string $id
 * @property integer $parent_id
 * @property string $title
 * @property string $alias
 * @property integer $status
 */
class PageCategory extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'page_category';
    }

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\SluggableBehavior::className(),
                'attribute' => 'alias',
                'slugAttribute' => 'alias',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['parent_id', 'status'], 'integer'],
            ['alias', 'unique'],
            [['title', 'alias'], 'required'],
            [['title', 'alias'], 'string', 'max' => 255],
        ];
    }
    
    public function beforeValidate() {
        parent::beforeValidate();
        $fields = [
            'title', 'alias', 
        ];
        foreach ($fields as $field) {
            $this->{$field} = strip_tags(\yii\helpers\HtmlPurifier::process($this->{$field}));
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'title' => 'Title',
            'alias' => 'Alias',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if($this->alias == ''){
                $this->alias = strtolower($this->title);
            } else {
                $this->alias = strtolower($this->alias);
            }
            $this->alias = str_replace(" ", "-", $this->alias);
        }
        return true;
    }
    
    public function beforeDelete() {
        if (parent::beforeDelete()) { 
            $childs =  \app\components\PageCategoryTree::getChildCategories($this->id);
            if($childs){
                foreach($childs as $c){
                    $this->deleteAll("id = '$c'");
                }
            }
        }
        return true;
    }
}
    