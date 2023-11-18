<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_teacher_attendance".
 *
 * @property int $id
 * @property int $teacher_id
 * @property int $is_present 0 = absent, 1 = present
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 */
class LmsTeacherAttendance extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lms_teacher_attendance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['teacher_id'], 'required'],
            [['teacher_id', 'is_present', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'teacher_id' => 'Teacher ID',
            'is_present' => 'Is Present',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public static function markAttendance($teacherIds) {


        if (count($teacherIds) > 0) {
            foreach ($teacherIds as $id) {
                $model = new \app\models\LmsTeacherAttendance();
                $model->teacher_id = $id;
                $model->is_present = 1;
                if (!$model->save()) {
                    echo \app\components\GeneralHelper::getErrorAsString($model);
                    exit;
                }
            }
            return [true, "Attendance marked for: " . date('l d M Y')];
        } else {
            return [false, "Please select at least one teacher to mark attendance"];
        }
    }

}
