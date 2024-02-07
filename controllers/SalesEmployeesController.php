<?php

namespace app\controllers;

use Carbon\Carbon;
use Yii;
use app\models\Tiger;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\SalesEmployees;
use yii\web\NotFoundHttpException;
use app\models\SalesEmployeesSearch;
use app\models\User;


/**
 * SalesEmployeesController implements the CRUD actions for SalesEmployees model.
 */
class SalesEmployeesController extends Controller
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
     * Lists all SalesEmployees models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SalesEmployeesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SalesEmployees model.
     * @param int $id ID
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
     * Creates a new SalesEmployees model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new SalesEmployees();
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $session = Yii::$app->session;
                $name = $model->employee->name ?? "";
                $session->set('message', Yii::t('app', 'salesEmployee', [
                    $model->date,
                    $name,
                    $model->amount
                ]));
                $session->set('date', $model->date);
                return $this->redirect(['sales-employees/create']);
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
     * Updates an existing SalesEmployees model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
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
     * Deletes an existing SalesEmployees model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SalesEmployees model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return SalesEmployees the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SalesEmployees::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionCalculation()
    {


        if ($this->request->isPost) {
            $data = $this->request->post();
            $date = Carbon::parse($data['date']);
            $amount = Carbon::parse($data['value']);

            $salesEmployees = SalesEmployees::find()->where(['date' => $date->toDateString()])->orderBy('amount', SORT_DESC)->all();

            if (count($salesEmployees)) {
                foreach ($salesEmployees as $salesEmployee) {
                    if ($salesEmployee->amount >= $amount) {
                        $newAmount = $salesEmployee->amount - $amount;
                        if ($newAmount == 0) {
                            $salesEmployee->payment_method = 'visa';
                            $salesEmployee->save();
                            return $this->asJson(["success" => 1]);
                        } else {
                            $model = new SalesEmployees();
                            $model->user_id = $salesEmployee->user_id;
                            $model->tiger = 0;
                            $model->payment_method = "visa";
                            $model->date = $date;
                            $model->amount = $amount;
                            $model->save();
                            $salesEmployee->amount = $newAmount;
                            $salesEmployee->save();
                            return $this->asJson(["success" => 1]);

                        }

                    } else {
                        $newAmount = $amount - $salesEmployee->amount;
                        if ($newAmount < 0) {

                        } elseif ($newAmount == 0) {

                        } else {

                        }
                    }
                }

            }

            return $this->asJson(["success" => 1]);

        }

    }
}
