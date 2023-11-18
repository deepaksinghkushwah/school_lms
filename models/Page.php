<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $content
 * @property string $alias
 * @property integer $add_date
 * @property integer $modify_date
 * @property int $status
 * @property string $allow_comment
 * @property string $allow_rating
 * @property string $show_social_share
 */
class Page extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'page';
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
            [['title', 'add_date', 'category_id'], 'required'],
            ['alias', 'unique'],
            [['content', 'meta_keywords', 'meta_description'], 'string'],
            [['add_date', 'modify_date', 'allow_comment', 'allow_rating', 'show_social_share','status'], 'integer'],
            [['title', 'alias'], 'string', 'max' => 255]
        ];
    }

    public function beforeValidate() {
        parent::beforeValidate();
        $fields = [
            'title', 'alias', 'meta_keywords', 'meta_description'
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
            'category_id' => 'Category',
            'title' => 'Title',
            'content' => 'Content',
            'alias' => 'Alias',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'add_date' => 'Add Date',
            'modify_date' => 'Modify Date',
            'status' => 'Published',
            'allow_rating' => 'Allow users to rate',
            'allow_comment' => 'Allow users to comment',
            'show_social_share' => 'Show social share links',
        ];
    }

}
