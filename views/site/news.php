<?php
use yii\widgets\ListView;
$this->title = "Latest News";
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'description', 'content' => $this->title]);
?>
<h1>Latest News</h1><hr/>
    <?php        
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_news_list',    
]);

