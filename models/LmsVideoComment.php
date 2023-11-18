<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lms_video_comment".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $video_id
 * @property string|null $content
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int $status
 *
 * @property LmsVideo $video
 */
class LmsVideoComment extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lms_video_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['parent_id', 'video_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['video_id', 'content'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['video_id'], 'exist', 'skipOnError' => true, 'targetClass' => LmsVideo::className(), 'targetAttribute' => ['video_id' => 'id']],
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
            'parent_id' => 'Parent ID',
            'video_id' => 'Video ID',
            'content' => 'Content',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Video]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVideo() {
        return $this->hasOne(LmsVideo::className(), ['id' => 'video_id']);
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            if ($this->parent_id == 0) {
                $subject = "New question posted";
                $msg = "New question posted on video <strong>" . $this->video->title . "</strong>, please click <a href='" . \yii\helpers\Url::to(['/student/default/video-view', 'id' => $this->video_id, '#' => 'q' . $this->id], true) . "'>here</a> to respond to question.";


                $teacher = Userprofile::findOne(['user_id' => $this->video->created_by]);

                $notification = new LmsNotification();
                $notification->title = $subject;
                $notification->message = $msg;
                $notification->from_user_id = Yii::$app->user->id;
                $notification->to_user_id = $teacher->user_id;
                $notification->status = 0;
                $notification->save();
            } else {
                $subject = "New reply added";
                $parent = self::findOne(['id' => $this->parent_id]);
                
                $msg = "New reply added to your question. Please click <a href='" . \yii\helpers\Url::to(['/student/default/video-view', 'id' => $this->video_id, '#' => 'q' . $parent->id], true) . "'>here</a> to view.";


                $to = Userprofile::findOne(['user_id' => $parent->created_by]);

                $notification = new LmsNotification();
                $notification->title = $subject;
                $notification->message = $msg;
                $notification->from_user_id = Yii::$app->user->id;
                $notification->to_user_id = $to->user_id;
                $notification->status = 0;
                $notification->save();
            }


            /* $mail = Yii::$app->mailer->compose(['html' => 'general-mail'], [
              'msg' => $msg,
              ]);
              $mail->setTo($teacher->user->email);
              $mail->setFrom(Yii::$app->params['settings']['admin_email']);
              $mail->setSubject($subject);
              $mail->send(); */
        }
    }

}
