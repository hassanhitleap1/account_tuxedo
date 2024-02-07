<?php

namespace app\modules\api\controllers;

use Carbon\Carbon;
use yii\web\ServerErrorHttpException;
use Yii;


class ExpensesController extends BaseActiveController
{
    public $modelClass = 'app\models\Expenses';


    public function actions()
    {
        $actions = parent::actions();



        // Override the index action
        $actions['index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'prepareDataProvider' => function () {
                // Customize your index action logic here
    
                $now = Carbon::now("Asia/Amman");
                $year = $now->year; // Get the current year
                $month = Yii::$app->getRequest()->getQueryParam('month', $now->month); // August
    
                $dataProvider = $this->modelClass::find()
                    ->where(['=', 'month(date)', $month])
                    ->where(['=', 'year(date)', $year])
                    ->all();

                return $dataProvider;
            },
        ];

        // Override the view action
        $actions['view'] = [
            'class' => 'yii\rest\ViewAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        // Override the update action
        $actions['update'] = [
            'class' => 'yii\rest\UpdateAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        return $actions;
    }

    // You can also override other actions if needed

    // For example, you can override the create action
    public function actionCreate()
    {
        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            Yii::$app->getResponse()->setStatusCode(201); // Created
            return $model;
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }

        return $model;
    }


}