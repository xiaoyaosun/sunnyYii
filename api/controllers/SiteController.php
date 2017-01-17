<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;

class SiteController extends Controller
{
    public $modelClass = 'api\modules\v1\models\Category';


   /* public function actions()
    {
        return [
            'error' => [
                'class' => 'api\actions\ErrorAction',
                'modelClass' => $this->modelClass,
            ],
        ];
    }*/
    public function actionError(){
       /* $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            \api\components\MyLog::log('$exception:'.var_export($exception,true));
        }*/
        \api\components\MyLog::logEnd();
    }
}