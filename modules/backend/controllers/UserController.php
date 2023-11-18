<?php

namespace app\modules\backend\controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use yii\base\Model;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = ['defaultOrder' => ['id' => SORT_DESC]];

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new \app\models\AdminSignupForm();
        $profile = new \app\models\Userprofile();
        $profile->scenario = 'create';

        if ($model->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                $user = $model->signup(10, $profile);
                if ($user) { // if user created
                    $mail = Yii::$app->mailer->compose(['html' => 'registermailAdmin'], ['user' => $user]);
                    $sub = 'Welcome to ' . Yii::$app->name;
                    $mail->setTo($user->email);
                    $mail->setFrom(Yii::$app->params['settings']['admin_email']);
                    $mail->setSubject($sub);
                    $data = $mail->send();


                    return $this->redirect(['/backend/user/index']);
                }
            } else {
                Yii::$app->getSession()->setFlash('danger', 'Error at creating user');
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'profile' => $profile,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = \app\models\User::find()->where("id='$id'")->one();
        $profile = \app\models\Userprofile::find()->where("user_id = '$id'")->one();
        if ($model->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save()) { // if user saved          
                    if (\app\components\GeneralHelper::getUserRolesByID($model->id) != Yii::$app->request->post('User')['role']) {
                        Yii::$app->authManager->revokeAll($model->id);
                        $role = Yii::$app->authManager->getRole(Yii::$app->request->post('User')['role']);
                        Yii::$app->authManager->assign($role, $model->id);
                    }
                    $profile->image = \yii\web\UploadedFile::getInstance($profile, 'image');
                    if ($profile->image) {
                        $name = uniqid() . '.' . $profile->image->extension;
                        $profile->image->saveAs(Yii::$app->basePath . '/web/images/profile/' . $name);
                        $profile->image = $name;
                    } else {
                        $profile->image = \app\models\Userprofile::find()->where("user_id='" . $model->id . "'")->one()->image;
                    }
                    if ($profile->validate()) {
                        $profile->save();
                        return $this->redirect(['/backend/user/index']);
                    } else {
                        Yii::$app->getSession()->setFlash('danger', 'Error at updating profile');
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->getSession()->setFlash('danger', 'Error at updating user');
            }
        }
        return $this->render('update', [
                    'model' => $model,
                    'profile' => $profile,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExport() {
        $courses = \app\models\LmsMasterClass::find()->orderBy(['id' => SORT_ASC])->all();


        if (count($courses) > 0) {
            $spreadsheet = new Spreadsheet();
            $spreadsheet->removeSheetByIndex(0);
            $sheetIndex = 0;
            foreach ($courses as $course) {

                $sheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $course->title);
                $spreadsheet->addSheet($sheet, $sheetIndex);
                $sheetIndex++;
                $students = \app\components\GeneralHelper::getCourseStudents($course->id);
                if ($students) {
                    // add new work sheet
                    // set headers
                    $sheet->setCellValue('A1', 'Class');
                    $sheet->setCellValue('B1', 'Student Name');
                    $sheet->setCellValue('C1', 'Student Email');
                    $sheet->setCellValue('D1', 'Address');
                    $sheet->setCellValue('E1', 'Contact Info');

                    $sheet->getColumnDimension("A")->setAutoSize(true);
                    $sheet->getColumnDimension("B")->setAutoSize(true);
                    $sheet->getColumnDimension("C")->setAutoSize(true);
                    $sheet->getColumnDimension("D")->setAutoSize(true);
                    $sheet->getColumnDimension("E")->setAutoSize(true);


                    $c = 2;
                    foreach ($students as $row) {
                        $address = "";
                        
                            $address = $row['studentModel']->address_line1 . ','
                                    . $row['studentModel']->city0->name . ','
                                    . $row['studentModel']->county0->name . ','
                                    . $row['studentModel']->postcode . ','
                                    . $row['studentModel']->country0->name;
                        
                        $sheet->setCellValue('A' . $c, $course->title);
                        $sheet->setCellValue('B' . $c, $row['studentModel']->fullname);
                        $sheet->setCellValue('C' . $c, $row['studentModel']->user->email);
                        $sheet->setCellValue('D' . $c, $address);
                        $sheet->setCellValue('E' . $c, $row['studentModel']->contact_mobile);
                        $c++;
                    }
                }
            }
            $writer = new Xlsx($spreadsheet);
            $filename = Yii::$app->params['tempPathOs'] . 'Students Class Wise.xlsx';
            $writer->save($filename);
            unset($spreadsheet);
            \app\components\GeneralHelper::downloadFile($filename);
        }
    }

}
