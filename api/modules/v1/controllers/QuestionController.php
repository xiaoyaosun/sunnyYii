<?php

namespace api\modules\v1\controllers;

// 引入curl库
use api\components\Mycurl;

// 引入私有function
use api\components\Myfun;

// 引入Logic模型
use api\modules\v1\logic\L_user;
use api\modules\v1\logic\L_question;

// 引入统计模块
use api\components\WKStaclient;

define(DEBUG_LOG, '/opt/logs/debug/QuestionController-'.date('Y-m-d', time()).'.log');

class QuestionController extends \yii\web\Controller
{
	
################ 对外接口 #################

	// 禁用csrf
	// post表单会默认添加校验
	public $enableCsrfValidation = false;

    public function actionGetinfobyid()
	{
		
        $module = str_replace("\\", '_', __CLASS__);
        WKStaclient::tick($module, __FUNCTION__);
		
		$ret = array();
		$ret['error_code'] = 0;
		$ret['error_msg'] = '';
		$ret['data'] = '';
		
		$raw_param = base64_decode($_REQUEST['param']);
		$param = json_decode($raw_param, true);

		if (empty($param)) {
			
			// 有字段为空，参数错误
			$ret['error_code'] = 100;
			$ret['error_msg'] = '参数错误';
		} else {

			if (Myfun::checkEmptyKey($param, array('userID', 'token', 'paper_id', 'question_id', 'item_id', 'platform')) !== '') {
				
				// 有字段为空，参数错误
				$ret['error_code'] = 100;
				$ret['error_msg'] = '参数错误';
				
			} else {
				
				$ret = L_question::getinfobyID($param);
			}
		}

		if (!is_array($ret)) {
			$ret = array();
			$ret['error_code'] = 99;
			$ret['error_msg'] = '服务器开小差';
			$ret['data'] = '';
		}
		
		WKStaclient::report($module, __FUNCTION__, 1, 0, 'ok');
		
		// H5调用会有跨域问题，因此当H5调用传递callback参数时，另作处理
		if (isset($_REQUEST['callback']) and !empty($_REQUEST['callback'])) {

			echo $_REQUEST['callback'].'('.json_encode($ret).')';
		} else {
			
			echo json_encode($ret);
		}
    }
	
    public function actionGetfreeinfo()
	{
		
        $module = str_replace("\\", '_', __CLASS__);
        WKStaclient::tick($module, __FUNCTION__);
		
		$ret = array();
		$ret['error_code'] = 0;
		$ret['error_msg'] = '';
		$ret['data'] = '';
		
		$raw_param = base64_decode($_REQUEST['param']);
		$param = json_decode($raw_param, true);

		if (empty($param)) {
			
			// 有字段为空，参数错误
			$ret['error_code'] = 100;
			$ret['error_msg'] = '参数错误';
		} else {

			if (Myfun::checkEmptyKey($param, array('userID', 'token', 'platform')) !== '') {
				
				// 有字段为空，参数错误
				$ret['error_code'] = 100;
				$ret['error_msg'] = '参数错误';
				
			} else {
				
				$ret = L_question::getfreeinfo($param);
			}
		}

		if (!is_array($ret)) {
			$ret = array();
			$ret['error_code'] = 99;
			$ret['error_msg'] = '服务器开小差';
			$ret['data'] = '';
		}
		
		WKStaclient::report($module, __FUNCTION__, 1, 0, 'ok');
		
		// H5调用会有跨域问题，因此当H5调用传递callback参数时，另作处理
		if (isset($_REQUEST['callback']) and !empty($_REQUEST['callback'])) {

			echo $_REQUEST['callback'].'('.json_encode($ret).')';
		} else {
			
			echo json_encode($ret);
		}
    }
	
    public function actionGetids()
	{
	
        $module = str_replace("\\", '_', __CLASS__);
        WKStaclient::tick($module, __FUNCTION__);
		
		$ret = array();
		$ret['error_code'] = 0;
		$ret['error_msg'] = '';
		$ret['data'] = '';

		$raw_param = base64_decode($_REQUEST['param']);

		$param = json_decode($raw_param, true);

		if (empty($param)) {
			
			// 有字段为空，参数错误
			$ret['error_code'] = 100;
			$ret['error_msg'] = '参数错误';
		} else {

			if (Myfun::checkEmptyKey($param, array('userID', 'token', 'paper_id', 'platform')) !== '') {
				
				// 有字段为空，参数错误
				$ret['error_code'] = 100;
				$ret['error_msg'] = '参数错误';
				
			} else {
				
				$ret = L_question::getIDs($param);
			}
		}

		if (!is_array($ret)) {
			$ret = array();
			$ret['error_code'] = 99;
			$ret['error_msg'] = '服务器开小差';
			$ret['data'] = '';
		}
		
		WKStaclient::report($module, __FUNCTION__, 1, 0, 'ok');
		
		// H5调用会有跨域问题，因此当H5调用传递callback参数时，另作处理
		if (isset($_REQUEST['callback']) and !empty($_REQUEST['callback'])) {

			echo $_REQUEST['callback'].'('.json_encode($ret).')';
		} else {
			
			echo json_encode($ret);
		}
    }
	
	// 提交答案
    public function actionSubmit()
	{
	
        $module = str_replace("\\", '_', __CLASS__);
        WKStaclient::tick($module, __FUNCTION__);
		
		$ret = array();
		$ret['error_code'] = 0;
		$ret['error_msg'] = '';
		$ret['data'] = '';
		
		$raw_param = base64_decode($_REQUEST['param']);
		$param = json_decode($raw_param, true);

		if (empty($param)) {
			
			// 有字段为空，参数错误
			$ret['error_code'] = 100;
			$ret['error_msg'] = '参数错误';
		} else {

			if (Myfun::checkEmptyKey($param, array('userID', 'token', 'paper_id', 'answers_list', 'platform')) !== '') {
				
				// 有字段为空，参数错误
				$ret['error_code'] = 100;
				$ret['error_msg'] = '参数错误';
				
			} else {
				
				$ret = L_question::submitAnswers($param);
			}
		}

		if (!is_array($ret)) {
			$ret = array();
			$ret['error_code'] = 99;
			$ret['error_msg'] = '服务器开小差';
			$ret['data'] = '';
		}
		
		WKStaclient::report($module, __FUNCTION__, 1, 0, 'ok');
		
		// H5调用会有跨域问题，因此当H5调用传递callback参数时，另作处理
		if (isset($_REQUEST['callback']) and !empty($_REQUEST['callback'])) {

			echo $_REQUEST['callback'].'('.json_encode($ret).')';
		} else {
			
			echo json_encode($ret);
		}
    }
}
