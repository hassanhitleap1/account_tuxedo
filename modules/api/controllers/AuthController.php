<?php

namespace app\modules\api\controllers;

use app\models\LoginForm;
use app\models\User;
use Yii;

use yii\rest\Controller;
use yii\web\MethodNotAllowedHttpException;

class AuthController extends Controller
{
    use \app\modules\api\Response;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['bootstrap'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];

        return $behaviors;
    }



    public function actionLogin()
    {

        $model = new LoginForm();
        if ($this->request->isPost) {
            if ($model->load(\Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
                $user = User::findOne(Yii::$app->user->identity->id);
                $user->access_token = \Yii::$app->security->generateRandomString();
                $user->save();
                return $this->sendResponse($user);
            } else {
                $errors = $model->getErrors();
                return $this->errorResponse($errors[0], $model->getErrors());
            }
        } else {
            return $this->errorResponse("Method Not Allowed");

        }


    }




}

