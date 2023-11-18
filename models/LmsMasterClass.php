<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_master_class".
 *
 * @property int $id
 * @property string $title
 * @property float $price
 *
 * @property LmsClassSubject[] $lmsClassSubjects
 */
class LmsMasterClass extends \yii\db\ActiveRecord {

    public $subjects = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lms_master_class';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['title'], 'string', 'max' => 255],
                [['title', 'price'], 'required'],
                ['subjects', 'required', 'message' => 'Please select at least one subject'],
                ['price', 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLmsClassSubjects() {
        return $this->hasMany(LmsClassSubject::className(), ['class_id' => 'id']);
    }

    public static function getClassSubjects($classID) {
        $retArr = [];
        if ($classID != NULL && $classID != 0) {
            $model = LmsClassSubjectRelation::find()->where("class_id = " . $classID)->all();
            if ($model) {
                foreach ($model as $row) {
                    $retArr[] = ['id' => $row->subject_id, 'title' => $row->subject->title];
                }
            }
        } else {
            $model = LmsMasterSubject::find()->all();
            foreach ($model as $row) {
                $retArr[] = ['id' => $row->id, 'title' => $row->title];
            }
        }

        return $retArr;
    }

    public static function saveSubjects($classID, $postedSubjects) {
        // check if course have previous subjects
        $previousSelectedSubjects = self::getClassSubjects($classID);
        //echo "<pre>";print_r($previousSelectedSubjects);
        //exit;
        if (count($previousSelectedSubjects) > 0) {
            // remove any subject which is not in posted array but exists in db
            foreach ($previousSelectedSubjects as $key => $pv) {
                if (!in_array($pv['id'], $postedSubjects)) {
                    $model = LmsClassSubjectRelation::findOne(['class_id' => $classID, 'subject_id' => $pv['id']]);
                    if ($model) {
                        $model->delete();
                    }
                }
            }
        }
        // insert subject which are in posted subjects but do not exists in db
        if (count($postedSubjects) > 0) {
            foreach ($postedSubjects as $row) {
                $exists = LmsClassSubjectRelation::findOne(['class_id' => $classID, 'subject_id' => $row]);
                if (!$exists) {
                    $model = new LmsClassSubjectRelation();
                    $model->subject_id = $row;
                    $model->class_id = $classID;
                    $model->save();
                }
            }
        }
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        $this->saveSubjects($this->id, $this->subjects);
        return true;
    }

}
