<?php

namespace api\modules\v1\controllers;

// 引入私有function
use api\components\Myfun;

// 引入Logic模型
use api\modules\v1\logic\L_fenlei;

// 引入统计模块
use api\components\WKStaclient;

define(DEBUG_LOG, '/opt/logs/debug/FenleiController-' . date('Y-m-d', time()) . '.log');

/**
 * FenleiController implements the CRUD actions for Fenlei model.
 */
class FenleiController extends \yii\web\Controller
{

    // 禁用csrf
    // post表单会默认添加校验
    public $enableCsrfValidation = false;
	
	// 获取指定分类信息
    public function actionGetalllist()
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

			if (Myfun::checkEmptyKey($param, array('userID', 'token', 'type', 'platform')) !== '') {
				
				// 有字段为空，参数错误
				$ret['error_code'] = 100;
				$ret['error_msg'] = '参数错误';
				
			} else {
				
				$ret = L_fenlei::getAllList($param);
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
