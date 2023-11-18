<?php
/* @var $this yii\web\View */
/* @var $model app\models\LmsContent */
$this->title = "Search result for \"" . $q . "\"";
?>
<h1><?= $this->title; ?></h1>
<p><strong>Total Results: <?= $total ?></strong></p>
<table class="table table-striped">
    <?php
    if ($model) {
        foreach ($model as $row) {
            $author = $row->getAuthor();
            $title = preg_replace("/\w*?$q\w*/i", "<b>$0</b>", $row->title);
            ?>
            <tr>
                <td><?= $row->class->title; ?></td>
                <td><?= $row->subject->title; ?></td>
                <td><a href="<?= \yii\helpers\Url::to(['/student/default/content-detail', 'id' => $row->id], true) ?>"><?= $title; ?></a></td>
                <td><?= !empty($author) ? $author->fullname : 'n/a'; ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td colspan="4">
                <?php
                echo yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                ]);
                ?>
            </td>
        </tr>
        <?php
    } else {
        ?>
        <tr>
            <td>No result found</td>
        </tr>
        <?php
    }
    ?>
</table>
