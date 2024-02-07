<?php

namespace app\modules\api\controllers;


use app\models\Discounts;
use app\models\Draws;
use app\models\Expenses;
use app\models\SalesEmployees;
use app\models\WorkingHours;
use Carbon\Carbon;

use Yii;

class UserDataController extends BaseController
{



    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }



    public function actionIndex()
    {

        $now = Carbon::now("Asia/Amman");
        $year = $now->year; // Get the current year
        $month = Yii::$app->getRequest()->getQueryParam('month', $now->month); // August

        $expenses = Expenses::find()
            ->select(['expenses.date', 'SUM(expenses.amount) as sum_expense'])
            ->where(['=', 'month(date)', $month])
            ->where(['=', 'year(date)', $year])
            ->where(['user_id' => $this->user->id])
            ->groupBy('expenses.date')
            ->orderBy(['expenses.date' => SORT_ASC])
            ->asArray()
            ->all();

        $draws = Draws::find()
            ->select(['draws.date', 'SUM(draws.amount) as sum_draw'])
            ->where(['=', 'month(date)', $month])
            ->where(['=', 'year(date)', $year])
            ->where(['user_id' => 1])
            ->groupBy('draws.date')
            ->orderBy(['draws.date' => SORT_ASC])
            ->asArray()
            ->all();


        $salesEmployees = SalesEmployees::find()
            ->select('sales_employees.date, SUM(sales_employees.amount) as sum_sales ,SUM(sales_employees.tiger) as sum_tiger')
            ->where(['=', 'month(date)', $month])
            ->where(['=', 'year(date)', $year])
            ->where(['user_id' => 1])
            ->groupBy('sales_employees.date')
            ->orderBy(['sales_employees.date' => SORT_ASC])
            ->asArray()
            ->all();

        $workingHours = WorkingHours::find()->where(['month(' . WorkingHours::tableName() . '.date)' => $month])->all();
        $discounts = Discounts::find()
            ->select(['sum(amount) as sum_discount', 'date'])
            ->where(['month(' . Discounts::tableName() . '.date)' => $month])
            ->groupBy(Discounts::tableName() . '.date')
            ->orderBy([Discounts::tableName() . '.date' => SORT_ASC])
            ->asArray()
            ->all();



        $maxDayInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $datesInMonth = range(1, $maxDayInMonth);

        $data = [];
        foreach ($datesInMonth as $key => $day) {
            $formattedDate = sprintf("%04d-%02d-%02d", $year, $month, $day);
            $start_time = '';
            $end_time = '';
            $expenseAmount = 0;
            $sum_discount = 0;
            $sum_tiger = 0;
            $sum_sales = 0;
            $sum_draw = 0;


            foreach ($workingHours as $workingHour) {
                if ($workingHour->date == $formattedDate) {
                    $start_time = $workingHour->start_time;
                    $end_time = $workingHour->end_time;
                    break;
                }
            }

            foreach ($expenses as $expense) {
                if ($expense['date'] == $formattedDate) {
                    $expenseAmount = $expense['sum_expense'];
                    break;
                }
            }


            foreach ($discounts as $discount) {
                if ($discount['date'] == $formattedDate) {
                    $expenseAmount = $discount['sum_discount'];
                    break;
                }
            }


            foreach ($salesEmployees as $salesEmployee) {
                if ($salesEmployee['date'] == $formattedDate) {
                    $sum_tiger = $salesEmployee['sum_tiger'];
                    $sum_sales = $salesEmployee['sum_sales'];
                    break;
                }
            }
            foreach ($draws as $draw) {
                if ($draw['date'] == $formattedDate) {
                    $sum_draw = $draw['sum_draw'];

                    break;
                }
            }

            $data[] = [
                'date' => $formattedDate,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'expense' => $expenseAmount,
                'sum_discount' => $sum_discount,
                'sum_tiger' => $sum_tiger,
                'sum_sales' => $sum_sales,
                'sum_draw' => $sum_draw
            ];


        }


        return ['data' => $data];
    }


    public function actionWorkLogin()
    {

        if ($this->request->isPost) {


            $workingHoursModel = WorkingHours::find()->where(['emappley_id' => $this->user->id])->where(['date' => Carbon::now("Asia/Amman")->toDateString()])->one();
            if (is_null($workingHoursModel)) {
                $workingHours = new WorkingHours();

                $workingHours->start_time = Carbon::now("Asia/Amman")->toDateString();
                $workingHours->date = Carbon::now("Asia/Amman")->toDateString();

                $workingHours->user_id = $this->user->id;

                if ($workingHours->save(false)) {
                    return ["mess" => "success"]; // Created
                } else {
                    $workingHoursModel->start_time = Carbon::now("Asia/Amman")->toDateString();
                    if ($workingHoursModel->save(false)) {
                        return ["mess" => "success"]; // Created  
                    }
                    return ["mess" => "error", "error" => $workingHours->getErrors()]; // Created

                }
            } else {
                return ["mess" => "error", "error" => "الموظف سجل الدخول"];
            }

        }
        return ["mess" => "error", "errors" => "not send post"];

    }


    public function actionWorkLogout()
    {

        if ($this->request->isPost) {


            $workingHoursModel = WorkingHours::find()->where(['emappley_id' => $this->user->id])->where(['date' => Carbon::now("Asia/Amman")->toDateString()])->one();
            if (is_null($workingHoursModel)) {
                $workingHours = new WorkingHours();

                $workingHours->end_time = Carbon::now("Asia/Amman")->toDateString();
                $workingHours->date = Carbon::now("Asia/Amman")->toDateString();

                $workingHours->user_id = $this->user->id;

                if ($workingHours->save(false)) {
                    return ["mess" => "success"]; // Created
                } else {
                    $workingHoursModel->end_time = Carbon::now("Asia/Amman")->toDateString();
                    if ($workingHoursModel->save(false)) {
                        return ["mess" => "success"]; // Created  
                    }
                    return ["mess" => "error", "error" => $workingHours->getErrors()]; // Created

                }
            } else {
                return ["mess" => "error", "error" => "الموظف سجل الدخول"];
            }

        }
        return ["mess" => "error", "errors" => "not send post"];



    }
}



