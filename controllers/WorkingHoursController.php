<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\WorkingHours;
use app\models\WorkingHoursSearch;
use yii\web\NotFoundHttpException;

/**
 * WorkingHoursController implements the CRUD actions for WorkingHours model.
 */
class WorkingHoursController extends Controller
{


    public function init()
    {
        if (!Yii::$app->user->isGuest) {
            if (Yii::$app->user->identity->type != User::SUPER_ADMIN) {
                throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
            }
        }
        parent::init();
    }


    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all WorkingHours models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WorkingHoursSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WorkingHours model.
     * @param int $id رقم 
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WorkingHours model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new WorkingHours();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                $session = Yii::$app->session;
                $name = $model->employee->name ?? "";
                $session->set('message', Yii::t('app', 'workingHours', [
                    $name,
                    $model->start_time,
                    $model->end_time,
                    $model->date
                ]));
                return $this->redirect(['working-hours/create']);

                // return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing WorkingHours model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id رقم 
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing WorkingHours model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id رقم 
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WorkingHours model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id رقم 
     * @return WorkingHours the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WorkingHours::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }



    public function actionEnter()
    {

        $command = "ipconfig getifaddr en0";
        $localSSID = exec($command);
        echo $localSSID;
        $command = "ipconfig getifaddr en0";
        $localSSID = exec($command);
        echo $localSSID;
        exit;

    }
}
