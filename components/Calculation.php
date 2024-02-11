<?php

namespace app\components;

use app\models\SalesEmployees;
use Yii;

use yii\base\BaseObject;


class Calculation extends BaseObject
{

    public static function set($date, $amount)
    {
        $salesEmployees = SalesEmployees::find()
            ->where(['date' => $date->toDateString(), 'payment_method' => 'cash'])
            ->orderBy('amount', SORT_DESC)->all();

        if (count($salesEmployees)) {
            foreach ($salesEmployees as $salesEmployee) {
                $newAmount = (float) $salesEmployee->amount - (float) $amount;


                if ($newAmount == 0) {
                    $salesEmployee->payment_method = 'visa';
                    $salesEmployee->save();
                    return $newAmount;
                } elseif ($newAmount < 0) {
                    $salesEmployee->payment_method = 'visa';
                    $salesEmployee->save();

                    self::set($date, -1 * $newAmount);
                    return true;
                } else {

                    $salesEmployee->amount = $newAmount;
                    $salesEmployee->save();
                    $model = new SalesEmployees();
                    $model->user_id = $salesEmployee->user_id;
                    $model->tiger = 0;
                    $model->payment_method = "visa";
                    $model->date = $salesEmployee->date;
                    $model->amount = $amount;
                    $model->save();
                    return true;

                }


            }

        }

        return true;
    }

}
