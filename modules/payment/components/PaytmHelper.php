<?php

namespace app\modules\payment\components;

use Yii;

if (Yii::$app->params['paytm']['env'] == "TEST") {
    define('PAYTM_STATUS_QUERY_URL', Yii::$app->params['paytm']['test']['PAYTM_STATUS_QUERY_NEW_URL']);
    define('PAYTM_STATUS_QUERY_NEW_URL', Yii::$app->params['paytm']['test']['PAYTM_STATUS_QUERY_NEW_URL']);
    define('PAYTM_TXN_URL', Yii::$app->params['paytm']['test']['PAYTM_TXN_URL']);
} else {
    define('PAYTM_STATUS_QUERY_URL', Yii::$app->params['paytm']['live']['PAYTM_STATUS_QUERY_NEW_URL']);
    define('PAYTM_STATUS_QUERY_NEW_URL', Yii::$app->params['paytm']['live']['PAYTM_STATUS_QUERY_NEW_URL']);
    define('PAYTM_TXN_URL', Yii::$app->params['paytm']['live']['PAYTM_TXN_URL']);
}

class PaytmHelper {

    static function encrypt_e($input, $ky) {
        $key = html_entity_decode($ky);
        $iv = "@@@@&&&&####$$$$";
        $data = openssl_encrypt($input, "AES-128-CBC", $key, 0, $iv);
        return $data;
    }

    static function decrypt_e($crypt, $ky) {
        $key = html_entity_decode($ky);
        $iv = "@@@@&&&&####$$$$";
        $data = openssl_decrypt($crypt, "AES-128-CBC", $key, 0, $iv);
        return $data;
    }

    static function generateSalt_e($length) {
        $random = "";
        srand((double) microtime() * 1000000);

        $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
        $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
        $data .= "0FGH45OP89";

        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }

        return $random;
    }

    static function checkString_e($value) {
        if ($value == 'null')
            $value = '';
        return $value;
    }

    static function getChecksumFromArray($arrayList, $key, $sort = 1) {
        if ($sort != 0) {
            ksort($arrayList);
        }
        $str = self::getArray2Str($arrayList);
        $salt = self::generateSalt_e(4);
        $finalString = $str . "|" . $salt;
        $hash = hash("sha256", $finalString);
        $hashString = $hash . $salt;
        $checksum = self::encrypt_e($hashString, $key);
        return $checksum;
    }

    static function getChecksumFromString($str, $key) {

        $salt = self::generateSalt_e(4);
        $finalString = $str . "|" . $salt;
        $hash = hash("sha256", $finalString);
        $hashString = $hash . $salt;
        $checksum = self::encrypt_e($hashString, $key);
        return $checksum;
    }

    static function verifychecksum_e($arrayList, $key, $checksumvalue) {
        $arrayList = self::removeCheckSumParam($arrayList);
        ksort($arrayList);
        $str = self::getArray2StrForVerify($arrayList);
        $paytm_hash = self::decrypt_e($checksumvalue, $key);
        $salt = substr($paytm_hash, -4);

        $finalString = $str . "|" . $salt;

        $website_hash = hash("sha256", $finalString);
        $website_hash .= $salt;

        $validFlag = "FALSE";
        if ($website_hash == $paytm_hash) {
            $validFlag = "TRUE";
        } else {
            $validFlag = "FALSE";
        }
        return $validFlag;
    }

    static function verifychecksum_eFromStr($str, $key, $checksumvalue) {
        $paytm_hash = self::decrypt_e($checksumvalue, $key);
        $salt = substr($paytm_hash, -4);

        $finalString = $str . "|" . $salt;

        $website_hash = hash("sha256", $finalString);
        $website_hash .= $salt;

        $validFlag = "FALSE";
        if ($website_hash == $paytm_hash) {
            $validFlag = "TRUE";
        } else {
            $validFlag = "FALSE";
        }
        return $validFlag;
    }

    static function getArray2Str($arrayList) {
        $findme = 'REFUND';
        $findmepipe = '|';
        $paramStr = "";
        $flag = 1;
        foreach ($arrayList as $key => $value) {
            $pos = strpos($value, $findme);
            $pospipe = strpos($value, $findmepipe);
            if ($pos !== false || $pospipe !== false) {
                continue;
            }

            if ($flag) {
                $paramStr .= self::checkString_e($value);
                $flag = 0;
            } else {
                $paramStr .= "|" . self::checkString_e($value);
            }
        }
        return $paramStr;
    }

    static function getArray2StrForVerify($arrayList) {
        $paramStr = "";
        $flag = 1;
        foreach ($arrayList as $key => $value) {
            if ($flag) {
                $paramStr .= self::checkString_e($value);
                $flag = 0;
            } else {
                $paramStr .= "|" . self::checkString_e($value);
            }
        }
        return $paramStr;
    }

    static function redirect2PG($paramList, $key) {
        $hashString = self::getchecksumFromArray($paramList);
        $checksum = self::encrypt_e($hashString, $key);
    }

    static function removeCheckSumParam($arrayList) {
        if (isset($arrayList["CHECKSUMHASH"])) {
            unset($arrayList["CHECKSUMHASH"]);
        }
        return $arrayList;
    }

    static function getTxnStatus($requestParamList) {
        return self::callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
    }

    static function getTxnStatusNew($requestParamList) {
        return self::callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
    }

    static function initiateTxnRefund($requestParamList) {
        $CHECKSUM = self::getRefundChecksumFromArray($requestParamList, PAYTM_MERCHANT_KEY, 0);
        $requestParamList["CHECKSUM"] = $CHECKSUM;
        return self::callAPI(PAYTM_REFUND_URL, $requestParamList);
    }

    static function callAPI($apiURL, $requestParamList) {
        $jsonResponse = "";
        $responseParamList = array();
        $JsonData = json_encode($requestParamList);
        $postData = 'JsonData=' . urlencode($JsonData);
        $ch = curl_init($apiURL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postData))
        );
        $jsonResponse = curl_exec($ch);
        $responseParamList = json_decode($jsonResponse, true);
        return $responseParamList;
    }

    static function callNewAPI($apiURL, $requestParamList) {
        $jsonResponse = "";
        $responseParamList = array();
        $JsonData = json_encode($requestParamList);
        $postData = 'JsonData=' . urlencode($JsonData);
        $ch = curl_init($apiURL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($postData))
        );
        $jsonResponse = curl_exec($ch);
        $responseParamList = json_decode($jsonResponse, true);
        return $responseParamList;
    }

    static function getRefundChecksumFromArray($arrayList, $key, $sort = 1) {
        if ($sort != 0) {
            ksort($arrayList);
        }
        $str = self::getRefundArray2Str($arrayList);
        $salt = self::generateSalt_e(4);
        $finalString = $str . "|" . $salt;
        $hash = hash("sha256", $finalString);
        $hashString = $hash . $salt;
        $checksum = self::encrypt_e($hashString, $key);
        return $checksum;
    }

    static function getRefundArray2Str($arrayList) {
        $findmepipe = '|';
        $paramStr = "";
        $flag = 1;
        foreach ($arrayList as $key => $value) {
            $pospipe = strpos($value, $findmepipe);
            if ($pospipe !== false) {
                continue;
            }

            if ($flag) {
                $paramStr .= self::checkString_e($value);
                $flag = 0;
            } else {
                $paramStr .= "|" . self::checkString_e($value);
            }
        }
        return $paramStr;
    }

    static function callRefundAPI($refundApiURL, $requestParamList) {
        $jsonResponse = "";
        $responseParamList = array();
        $JsonData = json_encode($requestParamList);
        $postData = 'JsonData=' . urlencode($JsonData);
        $ch = curl_init($apiURL);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $refundApiURL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $jsonResponse = curl_exec($ch);
        $responseParamList = json_decode($jsonResponse, true);
        return $responseParamList;
    }

}
