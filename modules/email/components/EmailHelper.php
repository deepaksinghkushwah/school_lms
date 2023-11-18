<?php

namespace app\modules\email\components;

class EmailHelper {

    private $threadMails;

    public static function getEmailThread($parentId) {
        
        $model = \app\models\Mailing::findAll(['id' => $parentId]);
        foreach ($model as $row) {
            $threadMails[] = $row;
            if ($row->parent_id != 0) {
                $threadMails = array_merge_recursive($threadMails, self::getEmailThread($row->parent_id));
            }
        }

        return $threadMails;
    }

}
