<?php

namespace app\controllers;

use Yii;
use yii\db\Query;
use Carbon\Carbon;
use app\models\Debt;
use app\models\Draws;
use app\models\Sales;
use app\models\Tiger;
use app\models\User;
use yii\web\Response;
use yii\web\Controller;
use app\models\Expenses;
use app\models\Discounts;
use app\models\Employees;
use app\models\LoginForm;
use app\models\Commission;
use app\models\ContactForm;
use yii\filters\VerbFilter;
use app\models\WorkingHours;
use app\models\SalesEmployees;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */

    public function actionIndex()
    {

        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

        }
        if (Yii::$app->user->identity->type != User::SUPER_ADMIN) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }


        $today = Carbon::now("Asia/Amman");

        $date = $today->toDateString();
        $date = Yii::$app->getRequest()->getQueryParam('date', $date);

        $sales_amount_daily = SalesEmployees::find()->where(['date(' . SalesEmployees::tableName() . '.date)' => $date])->sum('amount');

        $sales_amount_daily_visa = SalesEmployees::find()->where([
            'date(' . SalesEmployees::tableName() . '.date)' => $date,
            'payment_method' => 'visa'
        ])->sum('amount');
        $sales_amount_daily_cash = SalesEmployees::find()
            ->where([
                'date(' . SalesEmployees::tableName() . '.date)' => $date,
                'payment_method' => 'cash'
            ])->sum('amount');
        $expenses_daily = Expenses::find()->where(['date(' . Expenses::tableName() . '.date)' => $date])->sum('amount');
        $salesEmployees = SalesEmployees::find()->where(['date(' . SalesEmployees::tableName() . '.date)' => $date])->all();


        $expenses = Expenses::find()->where(['date(' . Expenses::tableName() . '.date)' => $date])->all();

        return $this->render('index', [
            'sales_amount_daily' => $sales_amount_daily,
            'sales_amount_daily_visa' => $sales_amount_daily_visa,
            'sales_amount_daily_cash' => $sales_amount_daily_cash,
            'salesEmployees' => $salesEmployees,
            'expenses_daily' => $expenses_daily,
            'expenses' => $expenses,
            'date' => $date
        ]);
    }
    public function actionMonthy()
    {

        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));

        }

        if (Yii::$app->user->identity->type == User::USER) {

            return $this->redirect(['site/employee-details', 'id' => Yii::$app->user->identity->id]);
        }
        if (Yii::$app->user->identity->type != User::SUPER_ADMIN) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        $now = Carbon::now();
        $year = $now->year;
        $month = Yii::$app->getRequest()->getQueryParam('month', $now->month);
        $day = $now->day;

        $sales_amount_monthly = SalesEmployees::find()->where(['month(' . SalesEmployees::tableName() . '.date)' => $month])->sum('amount');

        $sales_amount_monthly_visa = SalesEmployees::find()->where([
            'month(' . SalesEmployees::tableName() . '.date)' => $month,
            'payment_method' => 'visa'
        ])->sum('amount');
        $sales_amount_monthly_cash = SalesEmployees::find()->where([
            'month(' . SalesEmployees::tableName() . '.date)' => $month,
            'payment_method' => 'cash'
        ])->sum('amount');

        $expenses_amount_monthly = Expenses::find()->where(['month(' . Expenses::tableName() . '.date)' => $month])->sum('amount');




        $users = User::find()->asArray()->all();



        foreach ($users as $key => $user) {

            $users[$key]['amount_debt'] = Expenses::find()->where(['month(expenses.date)' => $month, 'user_id' => $user['id'], 'year(expenses.date)' => $year, 'type_id' => Debt::TYPE_EXPENSES])->sum('amount') ?? 0;

            $users[$key]['amount_commission'] = Expenses::find()->where(['month(expenses.date)' => $month, 'user_id' => $user['id'], 'year(expenses.date)' => $year, 'type_id' => Commission::TYPE_EXPENSES])->sum('amount') ?? 0;

            $users[$key]['amount_draws'] = Expenses::find()->where(['month(expenses.date)' => $month, 'user_id' => $user['id'], 'year(expenses.date)' => $year, 'type_id' => Draws::TYPE_EXPENSES])->sum('amount') ?? 0;


            $users[$key]['amount_sales_employees'] = SalesEmployees::find()->where(['month(date)' => $month, 'user_id' => $user['id'], 'year(date)' => $year])->sum('amount') ?? 0;

            $users[$key]['amount_tiger'] = SalesEmployees::find()->where(['month(date)' => $month, 'user_id' => $user['id'], 'year(date)' => $year])->sum('tiger') ?? 0;

            $users[$key]['amount_discount'] = Discounts::find()->where(['month(date)' => $month, 'user_id' => $user['id'], 'year(date)' => $year])->sum('amount') ?? 0;


        }



        $firstDateOfMonth = date('Y-m-01');
        foreach ($users as $key => $user) {

            if ($user['start_date'] > $firstDateOfMonth) {
                Carbon::parse($user['start_date'])->day;
                $dayOfEmployee = $day - Carbon::parse($user['start_date'])->day;
                $users[$key]['available_debt'] = ((float) $user['salary'] / 30) * $dayOfEmployee - ((float) $user['amount_debt'] + (float) $user['amount_draws'] + $user['amount_discount']);
            } else {
                $users[$key]['available_debt'] = ((float) $user['salary'] / 30) * $day - ((float) $user['amount_debt'] + (float) $user['amount_draws'] + $user['amount_discount']);
            }

        }

        return $this->render('monthy', ['users' => $users, 'sales_amount_monthly' => $sales_amount_monthly, 'month' => $month, 'expenses_amount_monthly' => $expenses_amount_monthly, 'sales_amount_monthly_visa' => $sales_amount_monthly_visa, 'sales_amount_monthly_cash' => $sales_amount_monthly_cash]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }



    public function actionEmployeeDetails($id)
    {

        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        if (Yii::$app->user->identity->id != $id) {

            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }


        $now = Carbon::now();
        $query = new Query();
        $year = $now->year; // Get the current year
        $month = Yii::$app->getRequest()->getQueryParam('month', $now->month); // August
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $datesInAugust = range(1, $daysInMonth);


        $model = User::findOne($id);
        $workingHours = WorkingHours::find()->where(['month(' . WorkingHours::tableName() . '.date)' => $month])->all();


        $expenses = $query->select([
            'SUM(CASE WHEN type_id=' . Debt::TYPE_EXPENSES . ' THEN amount ELSE 0 END) AS sum_debt',
            'SUM(CASE WHEN type_id=' . Commission::TYPE_EXPENSES . ' THEN amount ELSE 0 END) AS sum_commission',
            'SUM(CASE WHEN type_id=' . Draws::TYPE_EXPENSES . ' THEN amount ELSE 0 END) AS sum_draws',
            'expenses.date',
        ])->from('expenses')
            ->where(['expenses.user_id' => $id, 'month(expenses.date)' => $month])
            ->groupBy('expenses.date')
            ->orderBy(['expenses.date' => SORT_ASC])
            // ->asArray()
            ->all();



        $sales = SalesEmployees::find()->select(['sum(tiger) as sum_tiger', 'sum(amount) as sum_sales', 'date'])
            ->where(['sales_employees.user_id' => $id, 'month(sales_employees.date)' => $month])
            ->groupBy('sales_employees.date')
            ->orderBy(['sales_employees.date' => SORT_ASC])
            ->asArray()
            ->all();



        $discounts = Discounts::find()
            ->select(['sum(amount) as sum_discount', 'date'])
            ->where(['month(' . Discounts::tableName() . '.date)' => $month])
            ->groupBy(Discounts::tableName() . '.date')
            ->orderBy([Discounts::tableName() . '.date' => SORT_ASC])
            ->asArray()
            ->all();



        return $this->render('employee-details', [
            'model' => $model,
            'workingHours' => $workingHours,
            'discounts' => $discounts,
            'datesInAugust' => $datesInAugust,
            'month' => $month,
            'year' => $year,
            'sales' => $sales,
            'expenses' => $expenses

        ]);
    }


    public function actionDetails()
    {

        if (Yii::$app->user->identity->type != User::USER) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        $id = Yii::$app->user->identity->user_id;
        $now = Carbon::now();
        $query = new Query();
        $year = $now->year; // Get the current year
        $month = Yii::$app->getRequest()->getQueryParam('month', $now->month); // August
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $datesInAugust = range(1, $daysInMonth);


        $model = Employees::findOne($id);
        $workingHours = WorkingHours::find()->where(['month(' . WorkingHours::tableName() . '.date)' => $month])->all();


        $expenses = $query->select([
            'SUM(CASE WHEN type_id=' . Debt::TYPE_EXPENSES . ' THEN amount ELSE 0 END) AS sum_debt',
            'SUM(CASE WHEN type_id=' . Commission::TYPE_EXPENSES . ' THEN amount ELSE 0 END) AS sum_commission',
            'SUM(CASE WHEN type_id=' . Draws::TYPE_EXPENSES . ' THEN amount ELSE 0 END) AS sum_draws',
            'expenses.date',
        ])->from('expenses')
            ->where(['expenses.user_id' => $id, 'month(expenses.date)' => $month])
            ->groupBy('expenses.date')
            ->orderBy(['expenses.date' => SORT_ASC])
            // ->asArray()
            ->all();



        $sales = SalesEmployees::find()->select(['sum(tiger) as sum_tiger', 'sum(amount) as sum_sales', 'date'])
            ->where(['sales_employees.user_id' => $id, 'month(sales_employees.date)' => $month])
            ->groupBy('sales_employees.date')
            ->orderBy(['sales_employees.date' => SORT_ASC])
            ->asArray()
            ->all();



        $discounts = Discounts::find()
            ->select(['sum(amount) as sum_discount', 'date'])
            ->where(['month(' . Discounts::tableName() . '.date)' => $month])
            ->groupBy(Discounts::tableName() . '.date')
            ->orderBy([Discounts::tableName() . '.date' => SORT_ASC])
            ->asArray()
            ->all();



        return $this->render('employee-details', [
            'model' => $model,
            'workingHours' => $workingHours,
            'discounts' => $discounts,
            'datesInAugust' => $datesInAugust,
            'month' => $month,
            'year' => $year,
            'sales' => $sales,
            'expenses' => $expenses

        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
