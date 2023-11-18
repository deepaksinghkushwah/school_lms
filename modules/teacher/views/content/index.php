<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LmsContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contents';
$this->params['breadcrumbs'][] = $this->title;
$postedModel = Yii::$app->request->get("LmsContentSearch");
$postedSubjectID = isset($postedModel['subject_id']) ? $postedModel['subject_id'] : 0;
$postedClassID = isset($postedModel['class_id']) ? $postedModel['class_id'] : 0;

$classSubjects = app\models\LmsMasterClass::getClassSubjects((int)$postedClassID);

?>
<div class="lms-content-index">

    <h1><?=$this->title?></h1><hr>

    <p>
        <?= Html::a('Create Content', ['create'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Reset Search', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'class_id' => [
                'label' => 'Class',
                'value' => function($model) {
                    return $model->class->title;
                },
                'filter' => Html::dropDownList('LmsContentSearch[class_id]', $postedClassID, yii\helpers\ArrayHelper::map(app\models\LmsMasterClass::find()->all(), 'id', 'title'), ['prompt' => 'Select ANY', 'class' => 'form-control']),
            ],
            'subject_id' => [
                'label' => 'Subject',
                'value' => function($model) {
                    return $model->subject->title;
                },
                'filter' => Html::dropDownList('LmsContentSearch[subject_id]',$postedSubjectID, yii\helpers\ArrayHelper::map($classSubjects, 'id', 'title'), ['prompt' => 'Select ANY', 'class' => 'form-control']),
            ],
            //'content:ntext',
            //'created_at',
            //'updated_at',
            //'updated_by',
            'status' => [
                'label' => 'Status',
                'value' => function($model) {
                    return $model->status == 1 ? 'Active' : 'Inactive';
                },
                'filter' => Html::dropDownList('LmsContentSearch[status]', (isset($_REQUEST['LmsContentSearch']['status']) ? $_REQUEST['LmsContentSearch']['status'] : ''), ['1' => 'Active', '0' => 'Inactive'], ['prompt' => 'Select ANY', 'class' => 'form-control']),
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {toggleStatus}',
                'headerOptions' => ['width' => '100px'],
                'buttons' => [
                    'toggleStatus' => function($url, $model, $key) {
                        if($model->status ==1){
                            return Html::a("<i class='glyphicon glyphicon-ok'></i>", yii\helpers\Url::to(['/teacher/content/toggle-content-status','id' => $model->id],true),['title' => 'Click to inactive']);
                        } else {
                            return Html::a("<i class='glyphicon glyphicon-remove'></i>", yii\helpers\Url::to(['/teacher/content/toggle-content-status','id' => $model->id],true),['title' => 'Click to active']);
                        }
                    }
                ]],
        ],
    ]);
    ?>


</div>
