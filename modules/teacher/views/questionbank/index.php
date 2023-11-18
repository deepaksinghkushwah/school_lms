<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LmsQuestionBankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Question Bank';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/fancybox/jquery.fancybox.min.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(yii\helpers\Url::to(['/js/fancybox/jquery.fancybox.css'], true));

$js = "$('.btnQuestionAnswer').fancybox({
    iframe : {
        css : {
            width : '800px',
            height: '600px',
        }
    }
});;";
$this->registerJs($js);

$postedModel = Yii::$app->request->get("LmsQuestionBankSearch");
$postedSubjectID = isset($postedModel['subject_id']) ? $postedModel['subject_id'] : 0;
$postedClassID = isset($postedModel['class_id']) ? $postedModel['class_id'] : 0;

$classSubjects = app\models\LmsMasterClass::getClassSubjects((int)$postedClassID);
?>
<div class="lms-question-bank-index">

    <h1><?= Html::encode($this->title) ?></h1><hr>

    <p>
        <?= Html::a('Create Question', ['create'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Reset Search', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
//        'pager' => [
//            'firstPageLabel' => 'First',
//            'lastPageLabel' => 'Last',
//        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'class_id' => [
                'label' => 'Class',
                'value' => function($model) {
                    return $model->class->title;
                },
                'filter' => Html::dropDownList('LmsQuestionBankSearch[class_id]', $postedClassID, yii\helpers\ArrayHelper::map(app\models\LmsMasterClass::find()->all(), 'id', 'title'), ['prompt' => 'Select ANY', 'class' => 'form-control']),
                'headerOptions' => ['width' => '15%'],
            ],
            'subject_id' => [
                'label' => 'Subject',
                'value' => function($model) {
                    return $model->subject->title;
                },
                'filter' => Html::dropDownList('LmsQuestionBankSearch[subject_id]', $postedSubjectID, yii\helpers\ArrayHelper::map($classSubjects, 'id', 'title'), ['prompt' => 'Select ANY', 'class' => 'form-control']),
                'headerOptions' => ['width' => '15%'],
            ],
            'question_text:ntext',
            'score_point' => [
                'label' => 'Score Point',
                'value' => function($model) {
                    return number_format($model->score_point, 2);
                },
                'headerOptions' => ['width' => '10%'],
            ],
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            //'status',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete} {answer}',
                'buttons' => [
                    'answer' => function($url, $model, $key ) {
                        return Html::a("<i class='glyphicon glyphicon-edit'></i>", yii\helpers\Url::to(['/teacher/questionanswer/index', 'qid' => $model->id], true), ['data-fancybox' => '', 'data-type' => 'iframe', 'class' => 'btnQuestionAnswer','title' => 'Manage answers']);
                    }
                ],
                'headerOptions' => ['width' => '10%'],
            ],
        ],
    ]);
    ?>


</div>
