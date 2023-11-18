<?php

namespace app\modules\backend\controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;

class TeacherController extends \yii\web\Controller {

    public function actionExport() {
        return $this->render('export');
    }

    public function actionExportXls() {
        $date =(string) Yii::$app->request->post('selected_date', date('m-Y'));
        if($date == ""){
            $date = date('m-Y');
        }
        
        $selectedMonth = explode("-", $date)[0];
        $selectedYear = explode("-", $date)[1];
        $teacherIDs = (array) Yii::$app->request->post('teacher');
        
        if(count($teacherIDs) <= 0) {
            $teachers = \app\components\GeneralHelper::getUsersByRole("Teacher");
            foreach($teachers as $t){
                $teacherIDs[] = $t['id'];
            }
        }

        if (count($teacherIDs) > 0) {
            $spreadsheet = new Spreadsheet();
            $spreadsheet->removeSheetByIndex(0);
            $sheetIndex = 0;
            foreach ($teacherIDs as $teacherID) {
                $teacher = \app\models\Userprofile::findOne(['user_id' => $teacherID]);
                // remove default work sheet                
                
                
                // add new work sheet
                $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $teacher->fullname);
                $spreadsheet->addSheet($sheet, $sheetIndex);
                
                
                $sheetIndex++;
                
                // set headers
                $sheet->setCellValue('A1', 'Date');
                $sheet->setCellValue('B1', 'Teacher');
                $sheet->setCellValue('C1', 'Attendance');
                
                $sheet->getColumnDimension("A")->setAutoSize(true);
                $sheet->getColumnDimension("B")->setAutoSize(true);
                $sheet->getColumnDimension("C")->setAutoSize(true);
                
                
                
                // get results
                $sql = "SELECT * FROM `lms_teacher_attendance` WHERE teacher_id = :teacherID AND YEAR(created_at) = :year && MONTH(created_at) = :month ORDER BY created_at ASC";
                $rows = Yii::$app->db->createCommand($sql)
                        ->bindParam(':year', $selectedYear)
                        ->bindParam(':month', $selectedMonth)
                        ->bindParam(':teacherID', $teacherID)
                        ->queryAll();

                // set rows in worksheet
                if ($rows) {
                    $c = 2;
                    foreach ($rows as $row) {
                        $sheet->setCellValue('A' . $c, date('Y-m-d H:i',strtotime($row['created_at'])));
                        $sheet->setCellValue('B' . $c, $teacher['fullname']);
                        $sheet->setCellValue('C' . $c, $row['is_present'] ? 'P' : 'A');
                        $c++;
                    }
                }
            }
            $writer = new Xlsx($spreadsheet);
            $filename = Yii::$app->params['tempPathOs'].$selectedMonth . "-" . $selectedYear . ' Attendance.xlsx';
            $writer->save($filename);
            unset($spreadsheet);
            \app\components\GeneralHelper::downloadFile($filename);
            
        }






        //$sheet = $spreadsheet->getActiveSheet();
    }

    public function actionAttendance() {
        if (Yii::$app->request->post('saveForm')) {
            $teacherIds = (array) Yii::$app->request->post('teacher_ids');
            $status = \app\models\LmsTeacherAttendance::markAttendance($teacherIds);
            if ($status[0] == true) {
                Yii::$app->session->setFlash('success', $status[1]);
            } else {
                Yii::$app->session->setFlash('danger', $status[1]);
            }

            return $this->refresh();
        }
        return $this->render('attendance');
    }

    public function actionRemoveAttendanceEntry($id) {
        $model = \app\models\LmsTeacherAttendance::findOne($id);
        $model->delete();
        return json_encode(['msg' => 'Attendance entry removed']);
    }
    
    public function downloadFile($file) {        
        
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
            unlink($filename);
        } else
            die('Error - can not open file.');
        die();
    }

}
