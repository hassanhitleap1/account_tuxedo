<?php

// modules/api/ApiModule.php

namespace app\modules\api;

use yii\base\Module;
use Yii;

trait Response
{
    // some code...

    public function sendResponse($data = null, $statusCode = 200)
    {
        Yii::$app->response->setStatusCode($statusCode);
        return \yii\helpers\Json::encode(['success' => true, 'data' => $data]);
    }
    public function errorResponse($message = "Error", $statusCode = 400)
    {
        Yii::$app->response->setStatusCode($statusCode);
        return \yii\helpers\Json::encode(['success' => true, 'code' => $statusCode, 'message' => $message]);
    }
}