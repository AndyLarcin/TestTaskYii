<?php

namespace app\controllers;

use Yii;
use app\models\Record;
use app\models\RecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

Yii::$container->set('asu\browserinfo\BrowserInfo', [
    'class' => 'asu\browserinfo\BrowserInfoBrowscap',
    'memoryLimit' => '512M'
]);

/**
 * RecordController implements the CRUD actions for Record model.
 */
class RecordController extends Controller
{
//    /**
//     * @var BrowserInfo
//     */
//    private $browserInfo = null;
//
//    /**
//     * @param string $id
//     * @param \yii\base\Module $module
//     * @param BrowserInfo $browserInfo
//     * @param array $config
//     */
//    public function __construct($id, $module, BrowserInfo $browserInfo, $config = []) {
//        $this->browserInfo = $browserInfo;
//        parent::__construct($id, $module, $config);
//    }
    public function behaviors()
    {
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
     * Lists all Record models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Record model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Record model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Record();

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->file->saveAs('upload/' . $model->file->baseName . '.' . $model->file->extension);
            $model->image = 'upload/' . $model->file->baseName . '.' . $model->file->extension;
            $model->create_date = date('Y-m-d h:m:s');
            $model->ip = Yii::$app->request->userIP;
//            $model->browser = $this->browserInfo->getBrowserName();
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Record model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Record model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * Finds the Record model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Record the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Record::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
