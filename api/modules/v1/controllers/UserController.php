<?php

namespace api\modules\v1\controllers;

// 引入curl库
use api\components\Mycurl;

// 引入私有function
use api\components\Myfun;

// 引入Logic模型
use api\modules\v1\logic\L_user;

define(DEBUG_LOG, '/opt/logs/debug/UserController-' . date('Y-m-d', time()) . '.log');

class UserController extends \yii\web\Controller
{

################ 对外接口 #################

    // 禁用csrf
    // post表单会默认添加校验
    public $enableCsrfValidation = false;

    /*
        用户登录
    */
    // 用户登录
    // 校验验证码
    // 从用户中心获取用户信息
    public function actionLogin()
    {
		
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

            if (Myfun::checkEmptyKey($param, array('mobile', 'randcode', 'type', 'platform')) !== '') {

                // 有字段为空，参数错误
                $ret['error_code'] = 100;
                $ret['error_msg'] = '参数错误';

            } else {
				$ret = L_user::getLoginInfo($param);
            }
        }

		if (!is_array($ret)) {
			$ret = array();
			$ret['error_code'] = 99;
			$ret['error_msg'] = '服务器开小差';
			$ret['data'] = '';
		}
		
		// H5调用会有跨域问题，因此当H5调用传递callback参数时，另作处理
		if (isset($_REQUEST['callback']) and !empty($_REQUEST['callback'])) {

			echo $_REQUEST['callback'].'('.json_encode($ret).')';
		} else {
			
			echo json_encode($ret);
		}
    }

    /*
        获取验证码

    */
    public function actionGetrandcode()
    {

        // 用户获取验证码
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

            if (Myfun::checkEmptyKey($param, array('mobile', 'type', 'platform')) !== '') {

                // 有字段为空，参数错误
                $ret['error_code'] = 100;
                $ret['error_msg'] = '参数错误';

            } else {
				$ret = L_user::getRandCode($param);
            }
        }

		if (!is_array($ret)) {
			$ret = array();
			$ret['error_code'] = 99;
			$ret['error_msg'] = '服务器开小差';
			$ret['data'] = '';
		}
		
        echo json_encode($ret);
    }

    /*
        获取当前用户信息
    */
    public function actionGetinfo()
    {

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

                $ret = L_user::getUserInfo($param);
            }
        }

		if (!is_array($ret)) {
			$ret = array();
			$ret['error_code'] = 99;
			$ret['error_msg'] = '服务器开小差';
			$ret['data'] = '';
		}
		
		// H5调用会有跨域问题，因此当H5调用传递callback参数时，另作处理
		if (isset($_REQUEST['callback']) and !empty($_REQUEST['callback'])) {

			echo $_REQUEST['callback'].'('.json_encode($ret).')';
		} else {
			
			echo json_encode($ret);
		}
    }

    /*
        获取当前是否非法
    */
    public function actionChecktoken()
    {

        $ret = array();
        $ret['error_code'] = 0;
        $ret['error_msg'] = '';
        $ret['data']['systime'] = date('Y-m-d H:i:s', time());

		$raw_param = base64_decode($_REQUEST['param']);
		$param = json_decode($raw_param, true);

        if (empty($param)) {

            // 有字段为空，参数错误
            $ret['error_code'] = 100;
            $ret['error_msg'] = '参数错误';
            $ret['data']['systime'] = date('Y-m-d H:i:s', time());
        } else {

            if (Myfun::checkEmptyKey($param, array('userID', 'token', 'platform')) !== '') {

                // 有字段为空，参数错误
                $ret['error_code'] = 100;
                $ret['error_msg'] = '参数错误';
                $ret['data']['systime'] = date('Y-m-d H:i:s', time());
            } else {

                $ret = L_user::checkToken($param);
            }
        }

		if (!is_array($ret)) {
			$ret = array();
			$ret['error_code'] = 99;
			$ret['error_msg'] = '服务器开小差';
			$ret['data'] = '';
		}
		
		// H5调用会有跨域问题，因此当H5调用传递callback参数时，另作处理
		if (isset($_REQUEST['callback']) and !empty($_REQUEST['callback'])) {

			echo $_REQUEST['callback'].'('.json_encode($ret).')';
		} else {
			
			echo json_encode($ret);
		}
    }

    // 用户微信登录
    // Add by wangyang
    // 2016/11/22
    public function actionWechatlogin()
    {

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

            if (Myfun::checkEmptyKey($param, array('openid', 'unionid', 'nickname', 'groupId', 'platform')) !== '') {

                // 有字段为空，参数错误
                $ret['error_code'] = 100;
                $ret['error_msg'] = '参数错误';

            } else {

				$ret = L_user::wechatLogin($param);
            }
        }

		if (!is_array($ret)) {
			$ret = array();
			$ret['error_code'] = 99;
			$ret['error_msg'] = '服务器开小差';
			$ret['data'] = '';
		}
		
		// H5调用会有跨域问题，因此当H5调用传递callback参数时，另作处理
		if (isset($_REQUEST['callback']) and !empty($_REQUEST['callback'])) {

			echo $_REQUEST['callback'].'('.json_encode($ret).')';
		} else {
			
			echo json_encode($ret);
		}
    }
	
    /*
        获取当前用户信息
    */
    public function actionCheckwhite()
    {

        $ret = array();
        $ret['error_code'] = 0;
        $ret['error_msg'] = '';
        $ret['data']['systime'] = date('Y-m-d H:i:s', time());

		$raw_param = base64_decode($_REQUEST['param']);
		$param = json_decode($raw_param, true);

        if (empty($param)) {

            // 有字段为空，参数错误
            $ret['error_code'] = 100;
            $ret['error_msg'] = '参数错误';
            $ret['data']['systime'] = date('Y-m-d H:i:s', time());
        } else {

            if (Myfun::checkEmptyKey($param, array('userID', 'token', 'mobile', 'type', 'platform')) !== '') {

                // 有字段为空，参数错误
                $ret['error_code'] = 100;
                $ret['error_msg'] = '参数错误';
                $ret['data']['systime'] = date('Y-m-d H:i:s', time());
            } else {

                $ret = L_user::checkWhite($param);
            }
        }

		if (!is_array($ret)) {
			$ret = array();
			$ret['error_code'] = 99;
			$ret['error_msg'] = '服务器开小差';
			$ret['data'] = '';
		}
		
		// H5调用会有跨域问题，因此当H5调用传递callback参数时，另作处理
		if (isset($_REQUEST['callback']) and !empty($_REQUEST['callback'])) {

			echo $_REQUEST['callback'].'('.json_encode($ret).')';
		} else {
			
			echo json_encode($ret);
		}
    }
	
    /*
        给用户授权
    */
    public function actionUpdatewhiteuser()
    {

        $ret = array();
        $ret['error_code'] = 0;
        $ret['error_msg'] = '';
        $ret['data']['systime'] = date('Y-m-d H:i:s', time());

		$raw_param = base64_decode($_REQUEST['param']);
		$param = json_decode($raw_param, true);

        if (empty($param)) {

            // 有字段为空，参数错误
            $ret['error_code'] = 100;
            $ret['error_msg'] = '参数错误';
            $ret['data']['systime'] = date('Y-m-d H:i:s', time());
        } else {

            if (Myfun::checkEmptyKey($param, array('userID', 'token', 'mobile', 'type', 'platform')) !== '') {

                // 有字段为空，参数错误
                $ret['error_code'] = 100;
                $ret['error_msg'] = '参数错误';
                $ret['data']['systime'] = date('Y-m-d H:i:s', time());
            } else {

                $ret = L_user::updateWhiteUser($param);
			}
        }

		if (!is_array($ret)) {
			$ret = array();
			$ret['error_code'] = 99;
			$ret['error_msg'] = '服务器开小差';
			$ret['data'] = '';
		}
		
		// H5调用会有跨域问题，因此当H5调用传递callback参数时，另作处理
		if (isset($_REQUEST['callback']) and !empty($_REQUEST['callback'])) {

			echo $_REQUEST['callback'].'('.json_encode($ret).')';
		} else {
			
			echo json_encode($ret);
		}
    }
}
