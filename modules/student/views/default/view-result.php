<?php
/* @var $this yii\web\View */
/* @var $exam \app\models\LmsExam */
/* @var $answers \app\models\LmsStudentResult */
$this->title = "Result For " . $exam->title;
$this->registerCss(".qpadding{padding: 5px;}");
$studentScore = $exam->getStudentScore($attemptId);
$examScore = $resultMain->exam_total_score;
if ($answers) {
    ?>
    <h1><?= $this->title; ?></h1><hr>
    <p><b>Your Score:</b> <?= $studentScore ?> out of <?= $examScore ?> <span style="font-size: 12px;" class="label label-success"><?= number_format(($studentScore * 100) / $examScore, 2) ?>%</span></p>
    <table class="table table-striped result table-responsive-md table-bordered">
        <?php
        foreach ($answers as $aRow) {
            ?>
            <tr>
                <td class="text-justify">
                    <b>Q.</b><?= $aRow->question->question_text ?><br>[Score: <?= $aRow->question_score ?>]<br>
                    <div class="qpadding <?= $aRow->correct_answer_id == $aRow->answer_id ? 'bg-success' : 'bg-danger' ?>">
                        <b>Your Answer:</b> <?= $aRow->answer_text ?>
                        <?php
                        if ($aRow->correct_answer_id != $aRow->answer_id) {
                            echo "<div><b>Correct Answer:</b> " . $aRow->correct_answer_text . "</div>";
                        }
                        ?>
                    </div>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
} else {
    ?>
    <h1><?= $this->title; ?></h1>
    <hr>
    <p>You didn't attempt this exam yet, take this exam and come back to see result</p>
    <?php
}
?>