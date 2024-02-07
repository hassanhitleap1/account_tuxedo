<?php

namespace app\modules\api\controllers;


use yii\rest\ActiveController;

class DefaultController extends ActiveController
{
    public function actionIndex()
    {

        return [
            'status' => 'success',
            'message' => 'API is working!',
        ];
    }
}