<?php

// modules/api/ApiModule.php

namespace app\modules\api;

use yii\base\Module;
use Yii;

class ApiModule extends Module
{
    public $controllerNamespace = 'app\modules\api\controllers';

    public function init()
    {
        parent::init();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    }
}
