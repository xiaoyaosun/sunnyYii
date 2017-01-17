<?php

namespace api\modules\v1\controllers;
use api\components\Mycurl;
use api\components\Myfun;

// 引入DB模型
use api\modules\v1\models\Questions;
use api\modules\v1\models\Answers;

use Yii;

// 引入Logic模型
use api\modules\v1\logic\L_user;


define(DEBUG_LOG, '/opt/logs/debug/SiteController-'.date('Y-m-d', time()).'.log');

class SiteController extends \yii\web\Controller
{
	
	// 禁用csrf
	// post表单会默认添加校验
	public $enableCsrfValidation = false;
	
    public function actionTestquestion()
    {
		
		$p['paper_id'] = 51;
		$p['question_id'] = 1411;
		$p['item_id'] = 5;

		$res = Questions::findInfoByID($p);
		$res1 = Answers::findInfoByID($p);
		
		$answer = array();
		foreach ($res1 as $row) {
			$answer[] = $row->attributes;
		}

		echo json_encode($answer);
    }

    public function actionTestdbconnect()
    {
		$connection = new \yii\db\Connection([
			 'dsn' => 'mysql:host=localhost;dbname=music',
			 'username' => 'root',
			 'password' => '123456',
		]);
		
		$connection->open();
		var_dump($connection);
	}
}
