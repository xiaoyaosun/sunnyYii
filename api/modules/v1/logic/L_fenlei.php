<?php

namespace api\modules\v1\logic;

// 引入私有function
use api\components\Myfun;

// 引入DB模型
use api\modules\v1\models\Fenlei;

// 引入Logic模型
use api\modules\v1\logic\L_user;

define(DEBUG_FENLEI_LOG, '/opt/logs/debug/FenleiLog-'.date('Y-m-d', time()).'.log');

class L_fenlei
{

################## Controller 区域 ##################
	
	// 获取分类内容
	public static function getAllList($p) {

		// token校验
		$token_check = L_user::checkToken($p);

		if ($token_check) {
			
			$p['page'] = !isset($p['page']) ? 0 : $p['page'];
			$p['limit'] = !isset($p['limit']) ? 10 : $p['limit'];
			
			// 从分类信息表中获取信息
			$type_info = Fenlei::findInfoByTypeID($p);
			
			global $TYPE_DEF;
			
			// 过滤不要的数组内容
			foreach ($type_info as $row) {
				$temp = $row->attributes;
				unset($temp['id']);
				unset($temp['create_time']);
				unset($temp['update_time']);
				$temp['type'] = $TYPE_DEF[(string)$p['type']];
				$ret['data']['type_info'][] = $temp;
			}			
		} else {
			
			$ret['error_code'] = 101;
			$ret['error_msg'] = '验证失败，请重新验证';
			$ret['data'] = '';
		}
		return $ret;
	}
	
}