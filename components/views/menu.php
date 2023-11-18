<?php
/* @var $this yii\web\View */
/* @var $menuModel app\models\Menu */
/* @var $menuItemModel app\models\MenuItem */

//get menu items
if ($menuModel) {
    $menuItems = [];
    foreach ($menuModel as $menu) {
        $menuItems['title'] = $menu->title;
        switch ($menu->menu_item_type) {
            case '1':// indivisual
                $menuItemModel = app\models\MenuItem::findAll(['menu_id' => $menu->id]);
                foreach ($menuItemModel as $item) {
                    $page = \app\models\Page::findOne(['id' => $item->item_id]);
                    $menuItems['items'][] = \yii\helpers\Html::a($page->title, \yii\helpers\Url::to(['/static/' . $page->alias], true));
                }
            //$menu[]['items'] = ;
            case '2': // category
                $menuItemModel = app\models\MenuItem::findOne(['menu_id' => $menu->id]);
                $pages = \app\models\Page::findAll(['category_id' => $menuItemModel->item_id]);
                foreach ($pages as $item) {
                    $menuItems['items'][] = \yii\helpers\Html::a($item->title, \yii\helpers\Url::to(['/static/' . $item->alias], true));
                }
                break;
        }

        switch ($menu->menu_type) {
            case '1': // dropdown
                showDropdown($menu, $menuItems);
                break;
            case '2' : // list
                showList($menu, $menuItems);
                break;
        }
    }
}
