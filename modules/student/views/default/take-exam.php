<?php
/* @var $this yii\web\View */
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/jquery-validation/jquery.validate.min.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/jquery-steps/jquery.steps.min.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/frontend/student/take-exam.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(yii\helpers\Url::to(['/js/jquery-steps/style.css'], true));
$examModel = app\models\LmsExam::findOne(['id' => $examId]);
$attempts = Yii::$app->db->createCommand("SELECT * from lms_student_result WHERE student_id = '" . Yii::$app->user->id . "' GROUP BY attempt_id")->query()->rowCount;
echo \yii\helpers\Html::hiddenInput("examId", $examId, ['id' => 'examId']);
echo \yii\helpers\Html::hiddenInput("saveResult", yii\helpers\Url::to(['/student/default/save-result'], true), ['id' => 'saveResult']);
?>
<h1><?= $examModel->title ?></h1>
<p class="badge badge-danger">Total Attempts: <?= $attempts ?></p>
<hr>
<?php
$questions = app\models\LmsExamQuestion::find()->where("exam_id = :examId", [':examId' => $examId])->all();
if ($questions) {
    ?>
    <form id="exam-form">
        <p>Total Questions: <?= count($questions) ?></p>
        <div id="wizard">
            <?php
            $c = 1;
            foreach ($questions as $qRow) {
                ?>
                <h6>Question <?= $c ?></h6>
                <section>
                    <b>Question <?= $c ?>.</b><?= $qRow->question->question_text ?> <br> [<b>Score:</b> <?= $qRow->score_point; ?>]<br>
                    <?php
                    $answers = app\models\LmsQuestionAnswerOption::find()->where("question_id = :qid", [':qid' => $qRow->question_id])->orderBy("rand()")->all();
                    if ($answers) {
                        ?>
                        <ul class="answers">
                            <?php
                            foreach ($answers as $aRow) {
                                ?>
                                <li>
                                    <div class="row">
                                        <div class="col-md-1"><input required type="radio" data-qid="<?= $qRow->question_id ?>" data-ans-id="<?= $aRow->id ?>" class="answers" name="ans_<?= $qRow->id ?>"/></div>
                                        <div class="col-md-11"><?= $aRow->answer_text ?></div>
                                    </div>

                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    }
                    ?>
                    <div class="validation-error" style="display: none;"></div>
                </section>
                <?php
                $c++;
            }
            ?>
        </div>
    </form>
    <?php
}
?>