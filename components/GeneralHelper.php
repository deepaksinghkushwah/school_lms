<?php

namespace app\components;

use Yii;

/**
 * Description of GeneralHelper
 *
 * @author deepak
 */
class GeneralHelper {

    public static function getErrorAsString($model) {
        ob_start();
        echo "<pre>";
        print_r($model->getErrors());
        echo "</pre>";
        $str = ob_get_contents();
        ob_end_flush();
        return $str;
    }

    public static function showCurrency($amt) {
        return '&#8377;' . number_format($amt, 2);
    }

    public static function getUsersByRole($roleName) {
        $retArr = [];
        $users = Yii::$app->authManager->getUserIdsByRole($roleName);
        if ($users) {
            foreach ($users as $key => $val) {
                $user = \app\models\User::findOne($val);
                if (Yii::$app->user->id == $user->id)
                    continue;
                $retArr[] = ['id' => $user->id, 'fullname' => $user->profile->fullname, 'email' => $user->email];
            }
        }
        return $retArr;
    }

    public static function getUserRolesByID($userID) {
        $roles = Yii::$app->authManager->getRolesByUser($userID);
        $mainRole = "";
        foreach ($roles as $key => $obj) {
            $mainRole = $key;
        }
        return $mainRole;
    }

    public static function getAllRoles() {
        $roles = Yii::$app->authManager->getRoles();
        $retArr = [];
        foreach ($roles as $key => $obj) {
            if ($key == "Super Admin")
                continue;
            $retArr[] = ['id' => $key, 'value' => $key];
        }
        return $retArr;
    }

    public static function downloadFile($file) {
        $filename = basename($file);
        if (!is_readable($file)) {
            die('File not found or inaccessible!');
        }
        $size = filesize($file);
        $name = $filename;
        $name = rawurldecode($name);
        $known_mime_types = array(
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "jpg" => "image/jpg",
            "php" => "text/plain",
            "doc" => "application/msword",
            'docs' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            "xls" => "application/vnd.ms-excel",
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            "ppt" => "application/vnd.ms-powerpoint",
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            "gif" => "image/gif",
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html" => "text/html",
            "png" => "image/png",
            "jpeg" => "image/jpg"
        );

        //if ($mime_type == '') {
        $file_extension = strtolower(substr(strrchr($file, "."), 1));
        if (array_key_exists($file_extension, $known_mime_types)) {
            $mime_type = $known_mime_types[$file_extension];
        } else {
            $mime_type = "application/force-download";
        };
        //};
        @ob_end_clean();
        if (ini_get('zlib.output_compression'))
            ini_set('zlib.output_compression', 'Off');
        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header("Content-Transfer-Encoding: binary");
        header('Accept-Ranges: bytes');

        if (isset($_SERVER['HTTP_RANGE'])) {
            list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
            list($range) = explode(",", $range, 2);
            list($range, $range_end) = explode("-", $range);
            $range = intval($range);
            if (!$range_end) {
                $range_end = $size - 1;
            } else {
                $range_end = intval($range_end);
            }

            $new_length = $range_end - $range + 1;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range-$range_end/$size");
        } else {
            $new_length = $size;
            header("Content-Length: " . $size);
        }

        $chunksize = 1 * (1024 * 1024);
        $bytes_send = 0;
        if ($file = fopen($file, 'r')) {
            if (isset($_SERVER['HTTP_RANGE']))
                fseek($file, $range);

            while (!feof($file) &&
            (!connection_aborted()) &&
            ($bytes_send < $new_length)
            ) {
                $buffer = fread($file, $chunksize);
                echo($buffer);
                flush();
                $bytes_send += strlen($buffer);
            }
            fclose($file);
            @unlink($filename);
        } else
            die('Error - can not open file.');
        die();
    }

    public static function getAllCourseWithStudents() {
        $retArr = [];
        $courses = \app\models\LmsMasterClass::find()->all();
        if ($courses) {
            foreach ($courses as $course) {
                $orderDetailRows = \app\models\PaymentOrderDetail::find()->where(['item_id' => $course->id])->orderBy(['item_id' => SORT_ASC])->all();
                foreach ($orderDetailRows as $odr) {
                    if ($odr->order->status == 1) {
                        $retArr[$course->id][] = [
                            'studentID' => $odr->order->user_id,
                            'studentModel' => \app\models\Userprofile::findOne(['user_id' => $odr->order->user_id]),
                        ];
                    }
                }
            }
        }
        return $retArr;
    }

    public static function getCourseStudents($courseID) {
        //echo "<pre>";echo $courseID."<hr>";
        $retArr = [];
        $x = self::getAllCourseWithStudents();
        //print_r($x);
        if (count($x) > 0) {
            $retArr = isset($x[$courseID]) ? $x[$courseID] : [];
        }
        return $retArr;
    }

}
