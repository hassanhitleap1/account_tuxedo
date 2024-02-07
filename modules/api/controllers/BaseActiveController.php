<?php

namespace app\modules\api\controllers;


use yii\rest\ActiveController;
use Yii;

class BaseActiveController extends ActiveController
{
    public function beforeAction($action)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $action;
    }
}