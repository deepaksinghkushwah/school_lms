<?php

/**
 * Description of CategoryTree
 * This widget draw cateory tree drop down list
 * Required params: parent_id (int, default 0), name (string), id (string), excludelist(array, default empty)
 * @author Deepak Singh Kushwah
 */

namespace app\components;

use yii;

class PageCategoryTree {

    /**
     * 
     * @param int $parent_id
     * @param string $name
     * @param string $id
     * @param array $exclude
     * @return string
     */
    public static function drawDropDownTreeAdmin($parent_id = 0, $name = 'tree', $id = 'tree', $exclude = NULL, $default_selected = NULL, $showRoot = true) {
        $str = "<select class='form-control' name='$name' id='$id'>";        
        if ($showRoot) {
            $str .= "<option value='0'>Root</option>";
        }
        ob_start();
        self::fetchCategories($parent_id, 0, $exclude, $default_selected);
        $str .=ob_get_contents();
        ob_end_clean();
        $str .= "</select>";
        return $str;
    }

    public static function drawDropDownTree($parent_id = 0, $name, $id, $exclude, $default_selected, $showRoot = true) {
        $str = "<select class='form-control' name='$name' id='$id'>";
        if ($showRoot) {
            $str .= "<option value='0'>Root</option>";
        }
        ob_start();
        self::fetchCategories($parent_id, 0, $exclude, $default_selected);
        $str .=ob_get_contents();
        ob_end_clean();
        $str .= "</select>";
        return $str;
    }

    /**
     * 
     * @param type $parent_id
     * @param type $level
     * @param type $exclude
     * @return null
     */
    private static function fetchCategories($parent_id, $level, $exclude, $default_selected) {
        $sql = "SELECT * FROM page_category WHERE parent_id='$parent_id'";
        $result = Yii::$app->db->createCommand($sql)->queryAll();
        if ($result && count($result) > 0) {
            foreach ($result as $row) {
                if (in_array($row['id'], $exclude))
                    continue;
                echo "<option " . ($default_selected == $row['id'] ? 'selected="selected"' : '') . " value='" . $row['id'] . "'>" . str_repeat("&nbsp;", $level * 3) . ucwords($row['title']) . "</option>";
                self::fetchCategories($row['id'], $level + 1, $exclude, $default_selected);
            }
        } else {
            return;
        }
    }

    public static function drawTree($parent_id = 0, $edit = 0, $published_only = true) {
        $str = "";
        ob_start();
        self::fetchCategoriesForTree($parent_id, 0, $edit, $published_only);
        $str .=ob_get_contents();
        ob_end_clean();
        return $str;
    }

    private static function fetchCategoriesForTree($parent_id, $level, $edit, $published_only) {
        $sql = "SELECT * FROM page_category WHERE parent_id='$parent_id'";
        if ($published_only) {
            $sql.=" AND published='Yes' ";
        }

        $sql.=" ORDER BY cat_name ASC ";
        $result = Yii::$app->db->createCommand($sql)->queryAll();
        if ($result && count($result) > 0) {

            foreach ($result as $row) {
                echo "<ul>";
                echo "<li>";
                echo "<a href='javascript:void(0);'>" . ucwords(strtolower($row['cat_name'])) . "</a>";
                if ($edit) {
                    echo "<span class='pull-right'>"
                    . "<a href='" . Yii::$app->urlManager->createAbsoluteUrl(['/backend/category/update', 'id' => $row['id']]) . "'>Edit</a> | "
                    . "<a onclick='javascript:if(confirm(\"Are you sure want to delete this category (with all subcats and products)?\")){ window.location.href=\"" . Yii::$app->urlManager->createAbsoluteUrl(['backend/category/delete', 'id' => $row['id']]) . "\" }' href='javascript:void(0);'>Delete</a>"
                    . "</span>";
                }
                self::fetchCategoriesForTree($row['id'], $level + 1, $edit, $published_only);
                echo "</li>";
                echo "</ul>";
            }
        } else {
            return;
        }
    }

    public static function getChildCategories($parent_id = 0) {
        $str = "";
        ob_start();
        self::fetchChildCategories($parent_id);
        $str.=ob_get_contents();
        ob_end_clean();
        return explode("|", rtrim($str, '|'));
    }

    public static function fetchChildCategories($parent_id) {
        $sql = "SELECT * FROM page_category WHERE parent_id='$parent_id' AND `status`='1'";
        $result = Yii::$app->db->createCommand($sql)->queryAll();
        if ($result && count($result) > 0) {

            foreach ($result as $row) {
                echo $row['id'] . "|";
                self::fetchChildCategories($row['id']);
            }
        } else {
            return;
        }
    }

    /*
     * Returns the auctions category tree as an array
     * Should be used for category selector drop-down
     */

    public static function getCategoryTreeArray() {

        $auctionCategoryOptions = strip_tags(
                self::drawDropDownTree(0, 'OnlineCollections[category_id]', 'onlinecollections-category_id', [], '', false), '<option>');
        $auctionCategoryOptionsArray = explode('</option>', $auctionCategoryOptions);

        array_walk($auctionCategoryOptionsArray, function(&$category, $key) {
            $category = str_replace('&nbsp;', '-', strip_tags($category));
        });

        return $auctionCategoryOptionsArray;
    }

    /**
     * @param $elements is the category array
     * @param $parent_id is the required category whose child categories to be filtered
     * @return array $output is the child categories of the given category
     * */
    public static function filterCategoriesByParentId(&$elements, $parent_id) {
        $output = array();
        foreach ($elements as $key => $val) {
            if ($key == $parent_id) {
                $output = (isset($elements[$key]['children'])) ? $elements[$key]['children'] : array();
            } else {
                if (isset($val['children'])) {
                    $output = self::filterCategoriesByParentId($val['children'], $parent_id);
                }
            }
            if (!empty($output))
                return $output;
        }
        return $output;
    }

    /**
     *
     * @param integer $catId is the category id
     * @return array|bool $result the root category of the given category
     */
    public static function getRootCategory($catId) {

        $query = new \yii\db\Query();
        $query->select('*')
                ->from('auction_category')
                ->where("published = :published AND id = :cat_id", [':published' => 'Yes', ':cat_id' => $catId]);

        $result = $query->one();

        if ($result['parent_id'] != 0) {
            $result = self::getRootCategory($result['parent_id']);
        }

        return $result;
    }

    /**
     * @param integer $catId is the required category
     * @param integer $level is to determine the hierarchy level
     * @return array $result all the parent categories of the given category
     * */
    public static function getParentCategories($catId, $level = 0) {
        $query = new \yii\db\Query();
        $query->select('*')
                ->from('page_category')
                ->where("status = :status AND id = :cat_id", [':status' => '1', ':cat_id' => $catId]);

        $result[$level] = $query->one();

        if ($result[$level]['parent_id'] != 0) {
            $result = array_merge(self::getParentCategories($result[$level]['parent_id'], $level + 1), $result);
        }

        return $result;
    }

    public static function getParentCategoriesAsString($catId, $seperator = " => ") {
        $cx = \app\models\PageCategory::findOne(['id' => $catId]);
        if ($cx && $cx->parent_id != 0) {
            $array = self::getParentCategories($catId);
            $retStr = "";
            for ($i = 0; $i < count($array) - 1; $i++) {
                $retStr .= $array[$i]['title'] . $seperator;
            }
            return rtrim($retStr, $seperator);
        } else {
            return "Root";
        }
    }

}
