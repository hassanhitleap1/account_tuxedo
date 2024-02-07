<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\Status;
use app\models\User;
use yii\rest\Controller;
use yii\filters\auth\HttpBasicAuth;
use yii\web\Response;
use Yii;

class AuthController extends Controller
{
    // public function behaviors()
    // {
    //     $behaviors = parent::behaviors();

    //     $behaviors['authenticator'] = [
    //         'class' => HttpBasicAuth::class,
    //         'auth' => function ($username) {
    //             $user = \app\models\User::findByUsername($username);
    //             return $user !== null ? $user : null;
    //         },
    //     ];

    //     return $behaviors;
    // }

    /**
     * Action to handle the login.
     * @return array
     */
    public function actionLogin()
    {
        $params = Yii::$app->request->post();

        $model = new LoginForm();


        if (empty($params['username']) || empty($params['password']))
            return [
                'status' => Status::STATUS_BAD_REQUEST,
                'message' => "Need username and password.",
                'data' => ''
            ];

        $user = User::findByUsername($params['username']);

        if ($user->validatePassword($params['password'])) {
            if (isset($params['consumer']))
                $user->consumer = $params['consumer'];
            if (isset($params['access_given']))
                $user->access_given = $params['access_given'];

            Yii::$app->response->statusCode = Status::STATUS_FOUND;
            $user->generateAuthKey();
            $user->save();
            return [
                'status' => Status::STATUS_FOUND,
                'message' => 'Login Succeed, save your token',
                'data' => [
                    'id' => $user->username,
                    'token' => $user->auth_key,
                    'email' => $user['email'],
                ]
            ];
        } else {
            Yii::$app->response->statusCode = Status::STATUS_UNAUTHORIZED;
            return [
                'status' => Status::STATUS_UNAUTHORIZED,
                'message' => 'Username and Password not found. Check Again!',
                'data' => ''
            ];
        }
    }
}
