<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'description', 'content' => $this->title]);
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/frontend/signup.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
//$model->role= "Student";
echo Html::hiddenInput("getCountyUrl", yii\helpers\Url::to(['/site/get-counties'],true),['id' => 'getCountyUrl']);
echo Html::hiddenInput("getCityUrl", yii\helpers\Url::to(['/site/get-cities'],true),['id' => 'getCityUrl']);
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1><hr>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'signup-create-form',
                'options' => ['enctype' => 'multipart/form-data'],]); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($profile, 'fullname')->textInput() ?>
            <?= $form->field($profile, 'contact_mobile')->textInput() ?>
            <?= $form->field($profile, 'address_line1')->textInput() ?>
            <?= $form->field($profile, 'country')->dropDownList(yii\helpers\ArrayHelper::map(\app\models\GeoCountry::find()->all(),'id','name'),['prompt' => 'Select Any']) ?>
            <?= $form->field($profile, 'county')->dropDownList([],['prompt' => 'Select Any']) ?>
            <?= $form->field($profile, 'city')->dropDownList([],['prompt' => 'Select Any']) ?>
            
            <?= $form->field($profile, 'postcode')->textInput() ?>
            
            <?= $form->field($profile, 'image')->fileInput(['class' => 'form-control']) ?>
            

            <div class="form-group">
                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
