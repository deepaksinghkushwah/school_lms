<?php
/* @var $this yii\web\View */
$this->title = "Teacher's Attendance";
$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/backend/teacher/attendance.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
$teachers = \app\components\GeneralHelper::getUsersByRole("Teacher");
?>
<div class="col-md-6">
    <h3>Mark Attendance For: <strong><?= date("l d M Y") ?></strong></h3>
    <?= \yii\helpers\Html::beginForm(\yii\helpers\Url::to(['/backend/teacher/attendance'], true), 'post') ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Teachers</th>
                <th><input type="checkbox" class="btnCheckAll"/>&nbsp;Check All</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($teachers) {
                foreach ($teachers as $teacher) {
                    $isMarked = \app\models\LmsTeacherAttendance::find()->where(['teacher_id' => $teacher['id'], 'DATE(created_at)' => date('Y-m-d')])->one();
                    $checked = $isMarked ? 'checked="checked"' : '';
                    ?>
                    <tr>
                        <td><?= $teacher['fullname'] ?></td>
                        <td>
                            <?php if ($isMarked) { ?>
                                <?= date('l d M Y H:i', strtotime($isMarked->created_at)) ?>&nbsp;
                                <a class="removeEntry" data-href="<?= \yii\helpers\Url::to(['/backend/teacher/remove-attendance-entry', 'id' => $isMarked->id]) ?>" title="Remove attendance entry"><i class="glyphicon glyphicon-trash"></i></a>
                            <?php } else { ?>
                                <input class="attendanceCheckbox" <?= $checked ?> type="checkbox" name="teacher_ids[]" value="<?= $teacher['id'] ?>"/>
                            <?php } ?>
                        </td>
                    </tr>

                    <?php
                }
                ?>
                <tr>
                    <td></td>
                    <td><input class="btn btn-primary" type="submit" name="saveForm" value="Mark"/></td>
                </tr>
                <?php
            } else {
                ?>
                <tr>
                    <td colspan="2">No teachers found</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?= \yii\helpers\Html::endForm(); ?>
</div>