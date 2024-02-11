<?php

namespace app\modules\api\controllers;

use app\models\LoginForm;
use app\models\User;
use Yii;

use yii\rest\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\Response;
use yii\helpers\Security;


class AuthController extends Controller
{


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['bootstrap'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
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
                return ["success" => true, "data" => $user];
            } else {
                return ["success" => false, 'errors' => $model->getErrors()];
            }
        } else {
            throw new MethodNotAllowedHttpException('Method Not Allowed');
        }


    }




}

