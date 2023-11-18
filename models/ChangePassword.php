<?php

namespace app\models;

use app\models\User;
use yii\base\Model;
use yii;

/**
 * Password reset request form
 */
class ChangePassword extends Model {

    public $user;
    public $old_password;
    public $new_password;
    public $confirm_password;

    public function __construct($config = []) {
        $this->user = User::findOne(Yii::$app->user->id);
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['old_password', 'new_password', 'confirm_password'], 'required'],
            ['old_password', 'checkOldPassword'],
            [['new_password', 'confirm_password'], 'string', 'min' => 6],            
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password'],
        ];
    }
    
    public function beforeValidate() {
        parent::beforeValidate();
        $fields = [
            'old_password', 'new_password','confirm_password', 
        ];
        foreach ($fields as $field) {
            $this->{$field} = strip_tags(\yii\helpers\HtmlPurifier::process($this->{$field}));
        }
        return true;
    }

    public function checkOldPassword() {
        if (!Yii::$app->getSecurity()->validatePassword($this->old_password, $this->user->password_hash)) {
            $this->addError('old_password', 'Old password not match to your existing password.');
        }
    }

    public function changePassword() {
        $user = $this->user;
        $user->setPassword($this->new_password);
        return $user->save();
    }

}
