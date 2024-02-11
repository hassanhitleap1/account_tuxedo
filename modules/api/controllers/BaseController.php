<?php

namespace app\modules\api\controllers;


use app\models\User;
use app\modules\api\Response;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use Yii;
use yii\web\UnauthorizedHttpException;

class BaseController extends Controller
{

    use Response;
    public $user = null;
    public function behaviors()
    {

        $behaviors = parent::behaviors();
        $authorizationHeader = Yii::$app->request->headers->get('Authorization');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (preg_match('/^Bearer\s+(.*)$/', $authorizationHeader, $matches)) {
            $accessToken = $matches[1];
            $this->user = User::findIdentityByAccessToken($accessToken);
        } else {
            return $this->errorResponse("Method Not Allowed");

        }

        return $behaviors;



        ;
    }




}