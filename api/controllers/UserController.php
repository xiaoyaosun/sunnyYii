<?php

namespace api\controllers;

use yii\rest\Controller;

class UserController extends Controller {

    public $modelClass = 'common\models\User';

    public function actionView($id)
    {
        return User::findOne($id);
    }
} 