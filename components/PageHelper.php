<?php

namespace app\components;

use yii;

abstract class PageHelper {

    public static function getPageRating($pageId) {
        $totalRating = \app\models\PageRating::find()->where('page_id=' . $pageId)->sum('rating');
        $numberOfRating = \app\models\PageRating::find()->where('page_id=' . $pageId)->count();
        if ($numberOfRating != 0) {
            $avg = (int) $totalRating / $numberOfRating;
        } else {
            $avg = 0;
        }
        $img = "";
        for ($i = 0; $i < $avg; $i++) {
            $img .= yii\helpers\Html::img(\yii\helpers\Url::to(['/images/star.png'], true), ['width' => 20]);
        }
        for ($i = 0; $i < (10 - $avg); $i++) {
            $img .= yii\helpers\Html::img(\yii\helpers\Url::to(['/images/star-gray.png'], true), ['width' => 20]);
        }
        return ['img' => $img, 'totalNumberOfUsers' => $numberOfRating];
    }

}
