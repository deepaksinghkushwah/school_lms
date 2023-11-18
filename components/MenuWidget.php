<?php

namespace app\components;

/**
 * This widget will display banner on pages.
 *
 * @author Deepak Singh Kushwah
 */
class MenuWidget extends \yii\base\Widget {

    public $location;
    public $bottomMenuWidth = 4;

    public function init() {
        parent::init();
    }

    public function run() {
        $menuModel = \app\models\Menu::find()->where("location = '" . $this->location . "'AND `status` = 1")->orderBy(['sort_order' => SORT_ASC])->all();
        //echo "<pre>";print_r($model);echo "</pre>";

        if ($menuModel) {
            $menuItems = [];
            foreach ($menuModel as $menu) {
                $menuItems['title'] = $menu->title;
                $menuItems['items'] = [];
                switch ($menu->menu_item_type) {
                    case '1':// indivisual
                        $menuItemModel = \app\models\MenuItem::findAll(['menu_id' => $menu->id]);
                        if ($menuItemModel) {
                            foreach ($menuItemModel as $item) {
                                $page = \app\models\Page::findOne(['id' => $item->item_id]);
                                $menuItems['items'][] = \yii\helpers\Html::a($page->title, \yii\helpers\Url::to(['/static/' . $page->alias], true));
                            }
                        }
                    //$menu[]['items'] = ;
                    case '2': // category
                        $menuItemModel = \app\models\MenuItem::findOne(['menu_id' => $menu->id]);
                        if ($menuItemModel) {
                            $pages = \app\models\Page::find()->where(['category_id' => $menuItemModel->item_id])->orderBy(['id' => SORT_DESC])->all();
                            foreach ($pages as $item) {
                                $menuItems['items'][] = \yii\helpers\Html::a($item->title, \yii\helpers\Url::to(['/static/' . $item->alias], true));
                            }
                        }
                        break;
                }

                switch ($menu->menu_type) {
                    case '1': // dropdown
                        $this->showDropdown($menu, $menuItems);
                        break;
                    case '2' : // list
                        $this->showList($menu, $menuItems);
                        break;
                }
                unset($menuItems);
            }
        }
    }

    public function showList($menu, $menuItems) {
        if ($menu->location == 'bottom') {
            if (!empty($menuItems['items'])) {
                ?>
                <div class="col-md-<?= $this->bottomMenuWidth ?>" style="overflow: auto; max-height: 200px;">
                    <p><strong><?= $menu->title; ?></strong></p>
                    <ul class="list-unstyled">
                        <?php
                        foreach ($menuItems['items'] as $item) {
                            ?>
                            <li><a href="javascript:void(0);"><?= $item; ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <?php
            } else {
                echo "Empty menu added";
            }
        } else {

            if (!empty($menuItems['items'])) {
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><?= $menu->title; ?></div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <?php
                            foreach ($menuItems['items'] as $item) {
                                ?>
                                <tr><td><a href="javascript:void(0);"><?= $item; ?></a></td></tr>    
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
                <?php
            } else {
                echo "Empty menu added";
            }
        }
    }

    public function showDropdown($menu, $menuItems) {
        if (!empty($menuItems['items'])) {
            ?>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= $menu->title ?>
                    <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <?php
                    foreach ($menuItems['items'] as $item) {
                        ?>
                        <li><?= $item; ?></li>    
                        <?php
                    }
                    ?>
                </ul>
            </li>
            <?php
        } else {
            echo "Empty menu added";
        }
    }

}
