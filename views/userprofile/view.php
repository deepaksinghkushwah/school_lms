<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Userprofile */

$this->title = $model ? $model->fullname : 'No Profile Found';
$this->params['breadcrumbs'][] = ['label' => 'Userprofiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'description', 'content' => $this->title]);
?>
<div class="userprofile-view">

    <h1><?= Html::encode($this->title) ?></h1><hr>

    <p><?= Html::a('Manage Profile', ['update'], ['class' => 'btn btn-primary']) ?></p>

    <?php
    if ($model) {
        ?>
        <div class="row">
            <div class="col-lg-3">
                <?= Html::img(\yii\helpers\Url::to(['/images/profile/' . $model->image], true), ['class' => 'img-thumbnail']); ?><br/><br/>
                
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-3">
                        <b>Full Name</b>
                    </div>
                    <div class="col-lg-9">
                        <?= $model->fullname; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <b>Contact Number</b>
                    </div>
                    <div class="col-lg-9">
                        <?= $model->contact_mobile; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <b>Address  </b>
                    </div>
                    <div class="col-lg-9">
                        <?= $model->address_line1; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <b>City  </b>
                    </div>
                    <div class="col-lg-9">
                        <?= $model->city; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <b>County(State)  </b>
                    </div>
                    <div class="col-lg-9">
                        <?= $model->county; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <b>Postcode (Zip Code)</b>
                    </div>
                    <div class="col-lg-9">
                        <?= $model->postcode; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <b>Country</b>
                    </div>
                    <div class="col-lg-9">
                        <?= $model->country; ?>
                    </div>
                </div>
            </div>
        </div>





        <?php
    }
    ?>

</div>
