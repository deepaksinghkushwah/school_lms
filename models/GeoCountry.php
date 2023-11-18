<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "geo_country".
 *
 * @property int $id
 * @property string $sortname
 * @property string $name
 */
class GeoCountry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geo_country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sortname', 'name'], 'required'],
            [['sortname'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sortname' => 'Sortname',
            'name' => 'Name',
        ];
    }
}
