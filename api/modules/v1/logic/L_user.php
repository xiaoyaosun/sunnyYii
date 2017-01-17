<?php

namespace api\modules\v1\logic;

// 引入curl库
use api\components\Mycurl;

// 引入私有function
use api\components\Myfun;

// 引入DB模型
use api\modules\v1\models\User;
use api\modules\v1\models\Randcode;


define(DEBUG_LOG, '/opt/logs/debug/L_user-' . date('Y-m-d', time()) . '.log');

class L_user
{

################## Controller 区域 ##################

    // 获取用户登录信息
    public static function getLoginInfo($p)
    {

		$ret['error_code'] = 0;
		$ret['error_msg'] = '';
		$ret['data'] = '';
		
        // 检查验证码是否正确
        $checkcode = L_user::checkRandCode($p);
        //$checkcode = true;

        if ($checkcode === false) {

            $ret['error_code'] = 101;
            $ret['error_msg'] = '验证码不正确';
            $ret['data'] = '';
        } else {

			// 给用户创建userID和token
			$res = User::addNewUser($p);
			
			if (!empty($res)) {
				
				$ret['data']['user_info'] = $res;
			} else {
				$ret['error_code'] = 102;
				$ret['error_msg'] = '用户创建失败';
				$ret['data'] = '';
			}
        }

        return $ret;
    }

    // 获取验证码
    public static function getRandCode($p)
    {

        $ret = array();

        // 产生随机4位验证码
        $randcode = (string)Myfun::generate_code();

		// 存储验证码到DB中
		$p['randcode'] = $randcode;

        $randcode_res = Randcode::saveRandCode($p);

        if ($randcode_res === false) {

            $ret['error_code'] = 103;
            $ret['error_msg'] = '验证码生成错误';
            $ret['data'] = '';
        } else {

            if ($p['type'] == 1) {
                // 对接新的短信网关
                // Modify by wangyang
                // 2016/07/04
                $sms_res = Mycurl::my_vpost(URL_NEW_SEND_SMS, array(
                    'mobile' => $p['mobile'],
                    'account' => SMS_USER,
                    'password' => SMS_PASSWD,
                    'content' => 'xxx' . $randcode,
					'format' => 'json'),
                    '',
                    '',
                    false);
            }

            // 旧版本：返回值是 {"result":"1"}
            // 新版本：返回值是 {"state":"0x000000","message":"success","data":{"msgId":"1467634413102"}}
            $sms_arr = json_decode($sms_res['curl_res'], true);

            if (isset($sms_arr['code']) and ($sms_arr['code'] == 2)) {

                $time = time();
                $ret['error_code'] = 0;
                $ret['error_msg'] = '';
                $ret['data']['mobile'] = $p['mobile'];
                $ret['data']['randcode'] = '';
                $ret['data']['timestamp'] = $time;
                $ret['data']['valid_flag'] = true;
				$ret['data']['smsid'] = $sms_arr['smsid'];
            } else {

                $ret['error_code'] = 103;
                $ret['error_msg'] = '验证码生成错误';
                $ret['data'] = '';
            }
        }

        return $ret;
    }

    // 获取用户信息
    public static function getUserInfo($p)
    {

        // token校验
        $token_check = L_user::checkToken($p);

        if ($token_check) {

            // 用户信息表
            $user_res = User::findByUserID(base64_decode($p['userID']));

            if (empty($user_res)) {
                $ret['error_code'] = 102;
                $ret['error_msg'] = '信息获取失败';
                $ret['data'] = '';
            } else {
				$user_res = $user_res->attributes;
				unset($user_res['id']);
				unset($user_res['passwd']);
				unset($user_res['token']);
                $mobile = isset($user_res['mobile']) ? $user_res['mobile'] : '';
                if (!empty($mobile)) {
                    $mobile = substr($mobile, 0, 3) . '*****' . substr($mobile, -3);
                }
				$user_res['mobile'] = $mobile;
                $ret['error_code'] = 0;
                $ret['error_msg'] = '';
                $ret['data']['user_info'] = $user_res;
            }
        } else {

            $ret['error_code'] = 101;
            $ret['error_msg'] = '验证失败，请重新验证';
            $ret['data'] = '';
        }
        return $ret;
    }

    // 获取用户信息
    public static function checkWhite($p)
    {

        // token校验
        $token_check = L_user::checkToken($p);

        if ($token_check) {

            // 用户信息表
            $user_res = User::findWhiteByUserID(base64_decode($p['userID']), base64_decode($p['token']), $p['type'], $p['mobile']);

            if (empty($user_res)) {
                $ret['error_code'] = 102;
                $ret['error_msg'] = '信息获取失败';
                $ret['data'] = '';
            } else {

				// status = 1说明是已认证用户
				if ($user_res['status'] == 1) {
					
					$mobile = isset($user_res['mobile']) ? $user_res['mobile'] : '';
					if (!empty($mobile)) {
						$mobile = substr($mobile, 0, 3) . '*****' . substr($mobile, -3);
					}
					$ret['error_code'] = 0;
					$ret['error_msg'] = '';
					$ret['data']['mobile'] = $mobile;
				} else {
					$ret['error_code'] = 9;
					$ret['error_msg'] = '未授权用户';
				}
            }
        } else {

            $ret['error_code'] = 101;
            $ret['error_msg'] = '验证失败，请重新验证';
            $ret['data'] = '';
        }
        return $ret;
    }
	
    // 更新用户为已授权用户
    public static function updateWhiteUser($p)
    {

        // token校验
        $token_check = L_user::checkToken($p);

        if ($token_check) {

            // 用户信息表
            $user_res = User::updateWhiteUser(base64_decode($p['userID']), base64_decode($p['token']), $p['type'], $p['mobile']);

            if (empty($user_res)) {
                $ret['error_code'] = 103;
                $ret['error_msg'] = '用户授权失败';
                $ret['data'] = '';
            } else {

				$ret['error_code'] = 0;
				$ret['error_msg'] = '';
            }
        } else {

            $ret['error_code'] = 101;
            $ret['error_msg'] = '验证失败，请重新验证';
            $ret['data'] = '';
        }
        return $ret;
    }
	
############## 内部逻辑区域 ##############

    // 校验验证码
    public static function checkRandCode($p)
{

		// 新增type判断来源
		// 1代表app
		// 2代表pc端
		if (!isset($p['type'])) {
			$p['type'] = 1;
		}
		$randcode = Randcode::findByPhone($p['mobile'], $p['type']);
		$randcode_time = strtotime($randcode['last_create_time']);

		// 验证码有效期30分钟
		$valid_time = time();
		$ret = array();
		if (($randcode_time + CURL_RANDCODE_TIME) < $valid_time) {

			$ret['error_code'] = 112;
			$ret['error_msg'] = '验证码已失效';
			return false;
			//return $ret;
		}

		if (empty($randcode) or ($randcode['randcode'] != $p['randcode']) or ($randcode['status'] != '0')) {

			$ret['error_code'] = 113;
			$ret['error_msg'] = '验证码错误';
			return false;
		} else {

			// 删除用户验证码
			// 根据type类型删除
			// Modify by wangyang
			// 2016/08/19
			$del_res = Randcode::delByPhone($p['mobile'], $p['type']);

			// 删除错误时，
			if (empty($del_res)) {

				// 删除验证码失败
				
			}

			return true;
		}
    }

    // 校验token有效性
    public static function checkToken($p)
    {

		// 转换userID和token，base64解密
		$userID = base64_decode($p['userID']);
		$token = base64_decode($p['token']);
		
		// 读取DB，是否存在userID
		$res = User::checkToken($userID, $token);
		if (empty($res)) {
			return false;
		} else {
			return true;
		}
		
        return false;
    }
}