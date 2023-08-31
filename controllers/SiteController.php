<?php

namespace app\controllers;

use Yii;
use Carbon\Carbon;
use app\models\Debt;
use app\models\Draws;
use app\models\Sales;
use app\models\Tiger;
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

     public function actionIndex(){
        $today=Carbon::now("Asia/Amman");

        $date=$today->toDateString();
        $date= Yii::$app->getRequest()->getQueryParam('date', $date);

        $sales_amount_daily=SalesEmployees::find()->where(['date('.SalesEmployees::tableName().'.date)'=>$date])->sum('amount');
        $sales_amount_daily_visa=SalesEmployees::find()->where(['date('.SalesEmployees::tableName().'.date)'=>$date,
             'payment_method'=>'visa' ])->sum('amount'); 
        $sales_amount_daily_cash=SalesEmployees::find()
        ->where(['date('.SalesEmployees::tableName().'.date)'=>$date,
             'payment_method'=>'cash' ])->sum('amount'); 
        $expenses_daily=Expenses::find()->where(['date('.Expenses::tableName().'.date)'=>$date ])->sum('amount');     
        $salesEmployees=SalesEmployees::find()->where(['date('.SalesEmployees::tableName().'.date)'=>$date])->all();
        
       
        
        $expenses=Expenses::find()->where(['date('.Expenses::tableName().'.date)'=>$date ])->all();
        return $this->render('index',[
                    'sales_amount_daily'=>$sales_amount_daily,
                    'sales_amount_daily_visa'=>$sales_amount_daily_visa,
                    'sales_amount_daily_cash'=>$sales_amount_daily_cash,
                    'salesEmployees'=>$salesEmployees,
                    'expenses_daily'=>$expenses_daily,
                    'expenses'=>$expenses,
                    'date'=>$date
                ]);
        }
    public function actionMonthy()
    {
        $now = Carbon::now();
        $year= $now->year;
        $month= Yii::$app->getRequest()->getQueryParam('month', $now->month);
        $day = $now->day;

        $sales_amount_monthly=SalesEmployees::find()->where(['month('.SalesEmployees::tableName().'.date)'=>$month])->sum('amount');
        
        $sales_amount_monthly_visa=SalesEmployees::find()->where(['month('.SalesEmployees::tableName().'.date)'=>$month,
             'payment_method'=>'visa' ])->sum('amount'); 
        $sales_amount_monthly_cash=SalesEmployees::find()->where(['month('.SalesEmployees::tableName().'.date)'=>$month,
             'payment_method'=>'cash' ])->sum('amount'); 
        
        $expenses_amount_monthly=Expenses::find()->where(['month('.Expenses::tableName().'.date)'=>$month])->sum('amount'); 
       
        
        
        // $employees= Employees::find()->select([Employees::tableName().".*",
        // "(select IfNUll(sum(debt.amount),0) from debt where debt.employee_id = ".Employees::tableName().".id  and month(debt.date)= $month and year(debt.date)=$year )  as amount_debt",
        // "(select IfNUll(sum(commission.amount),0) from commission where commission.employee_id = ".Employees::tableName().".id  and month(commission.date)= $month  and year(commission.date)=$year )    as amount_commission",
        // "(select IfNUll(sum(draws.amount),0) from draws where draws.employee_id = ".Employees::tableName().".id  and month(draws.date)= $month  and year(draws.date)=$year ) as amount_draws",
        // "(select IfNUll(sum(tiger.amount),0) from tiger where tiger.employee_id = ".Employees::tableName().".id  and month(tiger.date)= $month   and year(tiger.date)=$year ) as amount_tiger",
        // "(select IfNUll(sum(sales_employees.amount),0) from sales_employees where sales_employees.employee_id = ".Employees::tableName().".id and month(sales_employees.date)= $month   and year(sales_employees.date)=$year) as amount_sales_employees",
        // "(select IfNUll(sum(discounts.amount),0) from discounts where discounts.employee_id = ".Employees::tableName().".id  and month(discounts.date)= $month   and year(discounts.date)=$year ) as amount_discount",
        // ])->asArray()->all();
       


        $employees= Employees::find()->select([Employees::tableName().".*",

        "(select IfNUll(sum(expenses.amount),0) from expenses where expenses.type_id = ".Debt::TYPE_EXPENSES."  and month(expenses.date)= $month and year(expenses.date)=$year )  as amount_debt",

        "(select IfNUll(sum(expenses.amount),0) from expenses where expenses.type_id = ".Commission::TYPE_EXPENSES."  and month(expenses.date)= $month  and year(expenses.date)=$year )    as amount_commission",

        "(select IfNUll(sum(expenses.amount),0) from expenses where expenses.type_id = ".Draws::TYPE_EXPENSES." and month(expenses.date)= $month  and year(expenses.date)=$year ) as amount_draws",


        "(select IfNUll(sum(sales_employees.tiger),0) from sales_employees where sales_employees.employee_id = ".Employees::tableName().".id  and month(sales_employees.date)= $month   and year(sales_employees.date)=$year ) as amount_tiger",
        
        "(select IfNUll(sum(sales_employees.amount),0) from sales_employees where sales_employees.employee_id = ".Employees::tableName().".id and month(sales_employees.date)= $month   and year(sales_employees.date)=$year) as amount_sales_employees",
        "(select IfNUll(sum(discounts.amount),0) from discounts where discounts.employee_id = ".Employees::tableName().".id  and month(discounts.date)= $month   and year(discounts.date)=$year ) as amount_discount",
        ])->asArray()->all();

        $firstDateOfMonth = date('Y-m-01');
       foreach($employees as $key => $employee){
        if($employee['start_date'] > $firstDateOfMonth  ){
            Carbon::parse($employee['start_date'])->day;
            $dayOfEmployee = $day - Carbon::parse($employee['start_date'])->day;
            $employees[$key]['available_debt']= ((float) $employee['salary'] / 30) *  $dayOfEmployee - (  (float)$employee['amount_debt']  + (float) $employee['amount_draws'] + $employee['amount_discount'])   ;
        }else{
            $employees[$key]['available_debt']= ((float) $employee['salary'] / 30) *  $day - (  (float)$employee['amount_debt']  + (float) $employee['amount_draws'] + $employee['amount_discount'])   ;
        }
 
       }
    
        return $this->render('monthy',['employees'=>$employees,'sales_amount_monthly'=>$sales_amount_monthly,'month'=>$month ,'expenses_amount_monthly'=>$expenses_amount_monthly,'sales_amount_monthly_visa'=>$sales_amount_monthly_visa,'sales_amount_monthly_cash'=>$sales_amount_monthly_cash]);
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



    public function actionEmployeeDetails($id){

        $now = Carbon::now();
        $year =$now->year; // Get the current year
        $month = Yii::$app->getRequest()->getQueryParam('month', $now->month);// August
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $datesInAugust = range(1, $daysInMonth);


        $model= Employees::findOne($id);
        $workingHours=WorkingHours::find()->where(['month('.WorkingHours::tableName().'.date)'=>$month])->all();
        $debts= Debt::find()->select(['sum(amount) as sum_debt','date'])
        ->where(['month('.Debt::tableName().'.date)'=>$month])
        ->groupBy(Debt::tableName().'.date')
        ->orderBy([Debt::tableName().'.date' => SORT_ASC])
        ->asArray()
        ->all();

       
        $commissions= Commission::find()
        ->select(['sum(amount) as sum_commission','date'])
        ->where(['month('.Commission::tableName().'.date)'=>$month])
        ->groupBy(Commission::tableName().'.date')
        ->orderBy([Commission::tableName().'.date' => SORT_ASC])
        ->asArray()
        ->orderBy(['date' => SORT_ASC])
        ->all();
        
       
        $draws= Draws::find()
        ->select(['sum(amount) as sum_draw','date'])
        ->where(['month('.Draws::tableName().'.date)'=>$month])
        ->groupBy(Draws::tableName().'.date')
        ->orderBy([Draws::tableName().'.date' => SORT_ASC])
        ->asArray()
        ->all();

        $tigers= Tiger::find()
        ->select(['sum(amount) as sum_tiger','date'])
        ->where(['month('.Tiger::tableName().'.date)'=>$month])
        ->groupBy(Tiger::tableName().'.date')
        ->orderBy([Tiger::tableName().'.date' => SORT_ASC])
        ->asArray()
        ->all();

        $discounts= Discounts::find()
        ->select(['sum(amount) as sum_discount','date'])
        ->where(['month('.Discounts::tableName().'.date)'=>$month])
        ->groupBy(Discounts::tableName().'.date')
        ->orderBy([Discounts::tableName().'.date' => SORT_ASC])
        ->asArray()
        ->all();

        
        


        return $this->render('employee-details', [
            'model' => $model,
            'workingHours'=>$workingHours,
             'commissions'=>$commissions,
             'draws'=>$draws,
             'tigers'=>$tigers,
            'debts'=>$debts,
            'discounts'=>$discounts,
            'datesInAugust'=>$datesInAugust,
            'month'=>$month,
            'year'=>$year

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
