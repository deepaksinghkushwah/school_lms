<?php

/* @var $this yii\web\View */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$username = Yii::$app->user->isGuest ? "Guest" : ucfirst(Yii::$app->user->identity->username);
$this->registerCss("#login-form{padding: 15px; min-width:300px;}");
$this->beginBlock('login');
echo "<div class='dropdown-menu'><div class='row'>
                            <div class='container-fluid'>";
$model = new app\models\LoginForm();
$form = ActiveForm::begin(['id' => 'login-form', 'action' => yii\helpers\Url::to(['/site/login'], true)]);
echo $form->field($model, 'username');
echo $form->field($model, 'password')->passwordInput();
echo $form->field($model, 'rememberMe')->checkbox();
echo '<div style="color:#999;margin:1em 0"> 
                    If you forgot your password you can ' . Html::a('reset it', Url::to(['site/request-password-reset'],true)) . '
                </div>
                <div class="form-group">
                    ' . Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) . '
                </div>';
/* echo yii\authclient\widgets\AuthChoice::widget([
  'baseAuthUrl' => ['site/auth'],
  'popupMode' => false,
  ]); */
ActiveForm::end();
echo "</div></div></div>";
$this->endBlock();

$this->beginBlock('dynamic_menu');
echo app\components\MenuWidget::widget(['location' => 'top']);
$this->endBlock();
$theme = \app\models\Theme::findOne(['default' => 1]);
yii\bootstrap\NavBar::begin([
    'brandLabel' => Yii::$app->params['settings']['application_name'],
    'brandUrl' => Yii::$app->homeUrl,
    'renderInnerContainer' => false,
    'options' => [
        'class' => 'navbar-default navbar-fixed-top navbar-'.$theme->inverse,
    ],
]);
echo "<div class='container-fluid'>";
echo \yii\bootstrap\Nav::widget([
    'options' => ['class' => 'navbar-nav','encodeLabels' => false],
    'items' => [
        ['label' => 'Home', 'url' => Yii::$app->homeUrl],
        //['label' => 'Latest News', 'url' => ['/news']],
        ['label' => 'About Us', 'url' => Url::to(['/static/about-us'],true)],
        ['label' => 'Contact Us', 'url' => Url::to(['/contact'],true)],
        [
            'label' => 'Chat Room', 'url' => Url::to(['/chat/default/index'],true),
            'visible' => !Yii::$app->user->isGuest,
            /*'linkOptions' => [
                'onclick' => 'window.open("'.Url::to(['/chat/default/index'],true).'", "mychatwindow", "directories=0,titlebar=0,toolbar=no,scrollbars=no,menubar=no,location=no,resizable=no,top=500,left=500,width=800,height=600")'
                
            ]*/
        ],
        $this->blocks['dynamic_menu'],
        
        [
            'label' => "Students Corner",
            'linkOptions' => ['title' => 'Students Corner'],
            'visible' => (!Yii::$app->user->isGuest && Yii::$app->user->can("Student")),
            'url' => ['#'],
            'active' => strstr(Yii::$app->request->url, "student") > -1 ? true : false,
            'items' => [
                ['label' => 'My Courses', 'url' => Url::to(['/student/default/index'],true), 'visible' => !Yii::$app->user->isGuest],
                ['label' => 'Exams', 'url' => Url::to(['/student/default/exams'],true), 'visible' => !Yii::$app->user->isGuest],
                ['label' => 'All Results', 'url' => Url::to(['/student/default/all-results'],true), 'visible' => !Yii::$app->user->isGuest],
            ],
        ],
        [
            'label' => "Teachers Corner",
            'linkOptions' => ['title' => 'Teachers Corner'],
            'visible' => (!Yii::$app->user->isGuest && Yii::$app->user->can("Teacher")),
            'url' => ['#'],
            'active' => (strstr(Yii::$app->request->url, "question") > -1 || strstr(Yii::$app->request->url, "media") > -1 || strstr(Yii::$app->request->url, "content") > -1 || strstr(Yii::$app->request->url, "exam/index") > -1) ? true : false,
            'items' => [
                ['label' => 'All Courses', 'url' => Url::to(['/student/default/index'],true), 'visible' => (!Yii::$app->user->isGuest && Yii::$app->user->can("Teacher"))],
                ['label' => 'Media Menager', 'url' => Url::to(['/teacher/media/index'],true), 'visible' => (!Yii::$app->user->isGuest && Yii::$app->user->can("Teacher"))],
                
                ['label' => 'Video Lectures', 'url' => Url::to(['/video/default/index'],true), 'visible' => (!Yii::$app->user->isGuest && Yii::$app->user->can("Teacher"))],
                
                ['label' => 'Content Manager', 'url' => Url::to(['/teacher/content/index'],true), 'visible' => (!Yii::$app->user->isGuest && Yii::$app->user->can("Teacher"))],
                ['label' => 'Question Bank', 'url' => Url::to(['/teacher/questionbank/index'],true), 'visible' => (!Yii::$app->user->isGuest && Yii::$app->user->can("Teacher"))],
                ['label' => 'Exam Manager', 'url' => Url::to(['/teacher/exam/index'],true), 'visible' => (!Yii::$app->user->isGuest && Yii::$app->user->can("Teacher"))],
            ],
        ],
    ],
]);
if(!Yii::$app->user->isGuest){
    $notificationCount = \app\models\LmsNotification::find()->where("to_user_id = ".Yii::$app->user->id.' AND `status` = 0')->count();
    $mailCount = \app\models\Mailing::find()->where("to_user = ".Yii::$app->user->id.' AND `status` = 0')->count();
    $cartItemCount = app\models\PaymentCart::find()->where(['created_by' => Yii::$app->user->id])->count();
} else {
    $notificationCount = 0;
    $mailCount = 0;
    $cartItemCount = 0;
}
echo \yii\bootstrap\Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'encodeLabels' => false,
    'items' => [
        ['label' => 'Signup', 'url' => array('/signup'), 'visible' => Yii::$app->user->isGuest],
        Yii::$app->user->isGuest ?
                [
            'label' => 'Login',
            'url' => 'javascript:void(0)',
            'items' => $this->blocks['login']
                ] :
    ['label' => '<span class="glyphicon glyphicon-bell"></span> '.($notificationCount > 0 ? '<span class="badge badge-primary">'.$notificationCount.'</span>' : ''), 'url' => yii\helpers\Url::to(['/notification/index'], true),'visible' => (!Yii::$app->user->isGuest),'linkOptions' => ['title' => 'Notifications']],            
    ['label' => '<span class="glyphicon glyphicon-envelope"></span> '.($mailCount > 0 ? '<span class="badge badge-primary">'.$mailCount.'</span>' : ''), 'url' => yii\helpers\Url::to(['/email/default/index'], true),'visible' => (!Yii::$app->user->isGuest),'linkOptions' => ['title' => 'Mail Inbox']],            
    ['label' => 'Shop', 'url' => yii\helpers\Url::to(['/shop/default/index'], true),'visible' => (!Yii::$app->user->isGuest && Yii::$app->user->can("Student")),'linkOptions' => ['title' => 'Purchase Courses']],            
    ['label' => '<i class="glyphicon glyphicon-shopping-cart"></i> Cart '.($cartItemCount > 0 ? '<span class="badge badge-primary">'.$cartItemCount.'</span>' : ''), 'url' => yii\helpers\Url::to(['/shop/default/cart'], true),'visible' => !Yii::$app->user->isGuest,'linkOptions' => ['title' => 'View your cart']],
        [
            'label' => $username,
            'visible' => !Yii::$app->user->isGuest,
            'url' => ['#'],
            'linkOptions' => ['title' => 'Members Menu'],
            'items' => [
                ['label' => 'My Profile', 'url' => Url::to(['/userprofile/index'],true), 'visible' => !Yii::$app->user->isGuest],
                ['label' => 'Change Password', 'url' => Url::to(['/userprofile/changepassword'],true), 'visible' => !Yii::$app->user->isGuest],                
                ['label' => 'Backend', 'url' => Url::to(['/backend/default/index'],true), 'visible' => key_exists("Super Admin", Yii::$app->getAuthManager()->getRolesByUser(Yii::$app->user->id))],                
                ['label' => 'Logout', 'url' => Url::to(['/logout'],true), 'linkOptions' => ['data-method' => 'post']],
            ],
        ],
        
    ],
]);

echo "</div>";
yii\bootstrap\NavBar::end();
?>