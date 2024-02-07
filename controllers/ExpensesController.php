<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Expenses;
use yii\filters\VerbFilter;
use app\models\ExpensesSearch;
use app\models\SalesEmployees;
use Carbon\Carbon;
use yii\web\NotFoundHttpException;
use app\models\User;

/**
 * ExpensesController implements the CRUD actions for Expenses model.
 */
class ExpensesController extends Controller
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
     * Lists all Expenses models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ExpensesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Expenses model.
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
     * Creates a new Expenses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Expenses();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $session = Yii::$app->session;
                $name = $model->employee->name ?? "";
                $typeOfExpense = $model->typeOfExpense->name ?? '';
                $session->set('message', Yii::t('app', 'expenses_success', [
                    $typeOfExpense,
                    $model->amount,
                    $name,
                    $model->date,
                    $model->month
                ]));


                $session->set('date', $model->date);

                return $this->redirect(['expenses/create']);
                //return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Expenses model.
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
     * Deletes an existing Expenses model.
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
     * Finds the Expenses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Expenses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Expenses::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionCalculationTiger()
    {
        if ($this->request->isPost) {
            $data = $this->request->post();
            $date = Carbon::parse($data['date']);
            $expense = Expenses::find()->where(['date' => $date->toDateString(), 'type_id' => 8])->one();

            if (is_null($expense)) {
                $expense = new Expenses();
                $expense->name = "عمولات";
                $expense->type_id = 8;
                $expense->month = $date->month;
                $expense->date = $data['date'];
                $expense->amount = SalesEmployees::find()->where(['date' => $date->toDateString()])->sum('tiger');
                $expense->save();

            }

            return $this->asJson(["success" => 1]);

        }

    }
}
