
<h1>test/index</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<div class="col-lg-5">
<?php
echo yii\jui\Accordion::widget([
     'items' => [
         [
             'header' => 'Section 1',
             'content' => 'Mauris mauris ante, blandit et, ultrices a, suscipit eget...',
         ],
         [
             'header' => 'Section 2',
             'headerOptions' => ['tag' => 'h3'],
             'content' => 'Sed non urna. Phasellus eu ligula. Vestibulum sit amet purus...',
             'options' => ['tag' => 'div'],
         ],
     ],
     'options' => ['tag' => 'div'],
     'itemOptions' => ['tag' => 'div'],
     'headerOptions' => ['tag' => 'h3'],
     'clientOptions' => ['collapsible' => true],
 ]);
?>
</div>