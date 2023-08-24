<?php

namespace  app\components;

use Yii;
use Carbon\Carbon;
use app\models\Debt;
use app\models\Draws;
use app\models\Sales;
use app\models\Tiger;

use app\models\Expenses;
use yii\base\BaseObject;
use app\models\Commission;

class Calculator extends BaseObject
{



    public static function addExpense($model ,$type_id)
    {
        $expense= new Expenses();
        $expense->amount =  $model->amount;
        $expense->employee_id= $model->employee_id;
        $expense->type_id= $type_id;
        $expense->date= $model->date;
        $expense->save();
    }


    public static function addCommission($model)
    {
        $commission= new Commission();
        $commission->amount =   $model->amount;
        $commission->employee_id= $model->employee_id;
        $commission->date= Carbon::parse($model->date."00:00");
        $commission->note= $model->name;
        $commission->save();
    }

    public static function addTiger($model)
    {
        $tiger= new Tiger();
        $tiger->amount =   $model->amount;
        $tiger->employee_id= $model->employee_id;
        $tiger->date= Carbon::parse($model->date."00:00");
        $tiger->note= $model->name;
        $tiger->save();
    }

    public static function addDraws($model)
    {
        $draws= new Draws();
        $draws->amount =   $model->amount;
        $draws->employee_id= $model->employee_id;
        $draws->date= Carbon::parse($model->date."00:00");
        $draws->note= $model->name;
        $draws->save();
    }

    public static function addDebt($model)
    {
        $debt= new Debt();
        $debt->amount =   $model->amount;
        $debt->employee_id= $model->employee_id;
        $debt->date= Carbon::parse($model->date."00:00");
        $debt->note= $model->name;
        $debt->save();
    }

    

    
    

    public static function removeCommission($model)
    {
        $commission= new Commission();
        $commission->amount =  $model->amount * $model->employee->commission;
        $commission->employee_id= $model->employee_id;
        $commission->date= $model->date;
        $commission->save();
    }
    public static function decreaseSales($model)
    {
        $dateTime = Carbon::parse($model->date);
        $sales = Sales::find()->andWhere('date(date) = :date', [':date' => $model->toDateString()])->one();
        
        if(is_null($sales )){
            $sales= new Sales();
            $sales->amount = (float) $sales->amount - (float)  $model->amount ;
            $sales->date = $model->date;
        }else{
            $sales->amount =  $model->amount ;    
        }
        $sales->save();
    }




    public static function increaseSales($model)
    {
    
        $dateTime = Carbon::parse($model->date);

        $sales = Sales::find()->andWhere('date(date) = :date', [':date' => $dateTime->toDateString()])->andWhere(['payment_method'=>$model->payment_method])->one();
       
        if(is_null($sales )){
            $sales= new Sales();
            $sales->amount  =  (float)   $model->amount ;
            $sales->date = $model->date;
            $sales->payment_method = $model->payment_method;
        }else{
            $sales->amount =  (float) $sales->amount + (float)  $model->amount ; 
        }

        $sales->save();
        
    }




    public static function faTOen($string) {
        return strtr($string, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
    }
  

}
