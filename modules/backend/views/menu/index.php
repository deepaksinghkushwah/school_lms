<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/fancybox/jquery.fancybox.min.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile(yii\helpers\BaseUrl::base() . '/js/fancybox/jquery.fancybox.min.css');

$this->registerJsFile(yii\helpers\BaseUrl::base() . '/js/backend/menu/index.js', ['position' => $this::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">



    <p>
        <?= Html::a('Create Menu', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'location' => [
                'label' => 'Locations',
                'value' => function($model) {
                    return Yii::$app->params['menu']['locations'][$model->location];
                },
                'filter' => Html::dropDownList('MenuSearch[location]', (isset($_REQUEST['MenuSearch']['location']) ? $_REQUEST['MenuSearch']['location'] : ''), Yii::$app->params['menu']['locations'], ['prompt' => 'Select Any', 'class' => 'form-control'])
            ],
            'sort_order',
            'menu_type' => [
                'label' => 'Menu Type',
                'value' => function($model) {
                    return Yii::$app->params['menu']['types'][$model->menu_type];
                },
                'filter' => Html::dropDownList('MenuSearch[menu_type]', (isset($_REQUEST['MenuSearch']['menu_type']) ? $_REQUEST['MenuSearch']['menu_type'] : ''), Yii::$app->params['menu']['types'], ['prompt' => 'Select Any', 'class' => 'form-control'])
            ],
            'menu_item_type' => [
                'label' => 'Menu Item Type',
                'value' => function($model) {
                    return Yii::$app->params['menu']['item_type'][$model->menu_item_type];
                },
                'filter' => Html::dropDownList('MenuSearch[menu_item_type]', (isset($_REQUEST['MenuSearch']['menu_item_type']) ? $_REQUEST['MenuSearch']['menu_item_type'] : ''), Yii::$app->params['menu']['item_type'], ['prompt' => 'Select Any', 'class' => 'form-control'])
            ],
            'status' => [
                'label' => 'Status',
                'value' => function($model) {
                    return Yii::$app->params['status'][$model->status];
                },
                'filter' => Html::dropDownList('MenuSearch[status]', (isset($_REQUEST['MenuSearch']['status']) ? $_REQUEST['MenuSearch']['status'] : ''), Yii::$app->params['status'], ['prompt' => 'Select Any', 'class' => 'form-control'])
            ],
            [
                'class' => 'yii\grid\ActionColumn', 'template' => '{items} {update} {delete}',
                'buttons' => [
                    'items' => function($url, $model) {
                        return "<a title='Manage Menu Items' data-fancybox data-type='iframe' class='menu_items' href='" . \yii\helpers\Url::to(['/backend/menu/menu-items', 'menu_id' => $model->id], true) . "'><i class='glyphicon glyphicon-link'></i></a>";
                    }
                ]
            ],
        ],
    ]);
    ?>


</div>
