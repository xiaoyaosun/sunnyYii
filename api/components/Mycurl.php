<?php

namespace api\components;

use Yii;

define(DEBUG_CURL_LOG, '/opt/logs/debug/CURL-'.date('Y-m-d', time()).'.log');

class Mycurl
{

	// get请求
	public static function my_vgetdebug($url, $data='', $cookie_name = '', $referer=CURL_REFERER, $proxy_enable = PROXY_ENABLE){ // 模拟提交数据函数
		$data = empty($data) ? '' : http_build_query($data);
var_dump($url.'?'.$data);
exit;
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url.'?'.$data); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_USERAGENT, CURL_USER_AGENT); // 模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		//curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		curl_setopt($curl, CURLOPT_TIMEOUT, CURL_TIMEOUT); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		
		if (!empty($cookie_name)) {
			curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_name);
		}
		curl_setopt($curl, CURLOPT_REFERER, $referer);

		if (!empty($proxy_enable)) {
			
			// 增加proxy代理信息
			// Modify by wangyang
			// 2016/06/13
			//$loginpassw = 'username:password';
			//$proxy_ip = 'ip';
			//$proxy_port = 'port';
			//$url = 'http://www.dianping.com';
			//curl_setopt($curl, CURLOPT_PROXYPORT, PROXY_PORT);
			//curl_setopt($curl, CURLOPT_PROXYTYPE, 'HTTP');
			//curl_setopt($curl, CURLOPT_PROXY, PROXY_IP);
			//curl_setopt($curl, CURLOPT_PROXYUSERPWD, PROXY_PASS);
		}

		$ret = array();
		$ret['curl_res'] = curl_exec($curl); // 执行操作
		$ret['curl_err'] = curl_errno($curl); // 获取错误码
		//if (curl_errno($curl)) {
		//   file_put_contents('curl_error.log', 'Errno'.curl_error($curl), FILE_APPEND);//捕抓异常
		//}
		curl_close($curl); // 关闭CURL会话
		return $ret; // 返回数据
	}
	
	public static function my_savecookie($url, $data='', $cookie_name, $referer=CURL_REFERER, $proxy_enable = PROXY_ENABLE){ // 模拟提交数据函数
		$data = empty($data) ? '' : http_build_query($data);
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_USERAGENT, CURL_USER_AGENT); // 模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		//curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
		curl_setopt($curl, CURLOPT_TIMEOUT, CURL_TIMEOUT); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_name); // 存储cookie
		curl_setopt($curl, CURLOPT_REFERER, $referer);

		if (!empty($proxy_enable)) {
			
			// 增加proxy代理信息
			// Modify by wangyang
			// 2016/06/13
			//$loginpassw = 'username:password';
			//$proxy_ip = 'ip';
			//$proxy_port = 'port';
			//$url = 'http://www.dianping.com';
			curl_setopt($curl, CURLOPT_PROXYPORT, PROXY_PORT);
			curl_setopt($curl, CURLOPT_PROXYTYPE, 'HTTP');
			curl_setopt($curl, CURLOPT_PROXY, PROXY_IP);
			curl_setopt($curl, CURLOPT_PROXYUSERPWD, PROXY_PASS);
		}

		$ret = array();
		$ret['curl_res'] = curl_exec($curl); // 执行操作
		$ret['curl_err'] = curl_errno($curl); // 获取错误码
		//if (curl_errno($curl)) {
		//   file_put_contents('curl_error.log', 'Errno'.curl_error($curl), FILE_APPEND);//捕抓异常
		//}
		curl_close($curl); // 关闭CURL会话
		return $ret; // 返回数据
	}
	
	// post请求途牛
	// Content-Type为” application/json; charset=utf-8” ;
	// 为支持数据传输 GZIP压缩数据,需要指定请求头Accept-Encoding 为 gzip
	public static function my_vposttuniu($url, $data='', $cookie_name='', $referer='', $proxy_enable = PROXY_ENABLE) { // 模拟提交数据函数
		
		$data = empty($data) ? '' : json_encode($data);
file_put_contents(DEBUG_CURL_LOG, Myfun::generateLogTime().' my_vposttuniu => data => '. $data ."\n", FILE_APPEND);
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
		//curl_setopt($curl, CURLOPT_USERAGENT, CURL_USER_AGENT); // 模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		//curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
		curl_setopt($curl, CURLOPT_TIMEOUT, CURL_TIMEOUT); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		if (!empty($cookie_name)) {
			curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_name);
		}
		//curl_setopt($curl, CURLOPT_REFERER, $referer);

		if (!empty($proxy_enable)) {
			
			// 增加proxy代理信息
			// Modify by wangyang
			// 2016/06/13
			//$loginpassw = 'username:password';
			//$proxy_ip = 'ip';
			//$proxy_port = 'port';
			//$url = 'http://www.dianping.com';
			curl_setopt($curl, CURLOPT_PROXYPORT, PROXY_PORT);
			curl_setopt($curl, CURLOPT_PROXYTYPE, 'HTTP');
			curl_setopt($curl, CURLOPT_PROXY, PROXY_IP);
			curl_setopt($curl, CURLOPT_PROXYUSERPWD, PROXY_PASS);
		}

		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Accept-Encoding: gzip',
			'Content-Type: application/json; charset=utf-8',
		));
		
		// 用于解析gzip格式
		curl_setopt($curl, CURLOPT_ENCODING, 'gzip');

		$ret = array();
		$ret['curl_res'] = curl_exec($curl); // 执行操作
		$ret['curl_err'] = curl_errno($curl); // 获取错误码

		curl_close($curl); // 关闭CURL会话
		return $ret; // 返回数据
	}

	// post请求
	public static function my_vpost($url, $data='', $cookie_name='', $referer=CURL_REFERER, $proxy_enable = PROXY_ENABLE){ // 模拟提交数据函数
		$data = empty($data) ? '' : http_build_query($data);
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_USERAGENT, CURL_USER_AGENT); // 模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		//curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
		curl_setopt($curl, CURLOPT_TIMEOUT, CURL_TIMEOUT); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		if (!empty($cookie_name)) {
			curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_name);
		}
		curl_setopt($curl, CURLOPT_REFERER, $referer);

		if (!empty($proxy_enable)) {
			
			// 增加proxy代理信息
			// Modify by wangyang
			// 2016/06/13
			//$loginpassw = 'username:password';
			//$proxy_ip = 'ip';
			//$proxy_port = 'port';
			//$url = 'http://www.dianping.com';
			curl_setopt($curl, CURLOPT_PROXYPORT, PROXY_PORT);
			curl_setopt($curl, CURLOPT_PROXYTYPE, 'HTTP');
			curl_setopt($curl, CURLOPT_PROXY, PROXY_IP);
			curl_setopt($curl, CURLOPT_PROXYUSERPWD, PROXY_PASS);
		}

		$ret = array();
		$ret['curl_res'] = curl_exec($curl); // 执行操作
		$ret['curl_err'] = curl_errno($curl); // 获取错误码

		curl_close($curl); // 关闭CURL会话
		return $ret; // 返回数据
	}
	
	// post请求
	public static function my_vpostjson($url, $data='', $cookie_name='', $referer='', $proxy_enable = PROXY_ENABLE){ // 模拟提交数据函数
		$data = empty($data) ? '' : json_encode($data);
file_put_contents(DEBUG_CURL_LOG, Myfun::generateLogTime().' my_vpostjson => data => '. $url."\n".$data ."\n", FILE_APPEND);
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_USERAGENT, CURL_USER_AGENT); // 模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		//curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
		curl_setopt($curl, CURLOPT_TIMEOUT, CURL_TIMEOUT); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		if (!empty($cookie_name)) {
			curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_name);
		}
		curl_setopt($curl, CURLOPT_REFERER, $referer);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Accept-Encoding: gzip',
			'Content-Type: application/json; charset=utf-8',
		));
		
		if (!empty($proxy_enable)) {
			
			// 增加proxy代理信息
			// Modify by wangyang
			// 2016/06/13
			//$loginpassw = 'username:password';
			//$proxy_ip = 'ip';
			//$proxy_port = 'port';
			//$url = 'http://www.dianping.com';
			curl_setopt($curl, CURLOPT_PROXYPORT, PROXY_PORT);
			curl_setopt($curl, CURLOPT_PROXYTYPE, 'HTTP');
			curl_setopt($curl, CURLOPT_PROXY, PROXY_IP);
			curl_setopt($curl, CURLOPT_PROXYUSERPWD, PROXY_PASS);
		}

		$ret = array();
		$ret['curl_res'] = curl_exec($curl); // 执行操作
		$ret['curl_err'] = curl_errno($curl); // 获取错误码

		curl_close($curl); // 关闭CURL会话

		return $ret; // 返回数据
	}
	
	// 存储cookie + 获取cookie
	public static function my_vcpost($url, $data='', $cookie_name, $referer=CURL_REFERER, $proxy_enable = PROXY_ENABLE){ // 模拟提交数据函数
		$data = empty($data) ? '' : http_build_query($data);
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_USERAGENT, CURL_USER_AGENT); // 模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		//curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
		curl_setopt($curl, CURLOPT_TIMEOUT, CURL_TIMEOUT); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_name);
		curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_name);
		curl_setopt($curl, CURLOPT_REFERER, $referer);

		if (!empty($proxy_enable)) {
			
			// 增加proxy代理信息
			// Modify by wangyang
			// 2016/06/13
			//$loginpassw = 'username:password';
			//$proxy_ip = 'ip';
			//$proxy_port = 'port';
			//$url = 'http://www.dianping.com';
			curl_setopt($curl, CURLOPT_PROXYPORT, PROXY_PORT);
			curl_setopt($curl, CURLOPT_PROXYTYPE, 'HTTP');
			curl_setopt($curl, CURLOPT_PROXY, PROXY_IP);
			curl_setopt($curl, CURLOPT_PROXYUSERPWD, PROXY_PASS);
		}

		$ret = array();
		$ret['curl_res'] = curl_exec($curl); // 执行操作
		$ret['curl_err'] = curl_errno($curl); // 获取错误码
		//if (curl_errno($curl)) {
		//   file_put_contents('curl_error.log', 'Errno'.curl_error($curl), FILE_APPEND);//捕抓异常
		//}
		curl_close($curl); // 关闭CURL会话
		return $ret; // 返回数据
	}

	// get请求，用于12308对接
	public static function my_vgetbus($url, $data=''){ // 模拟提交数据函数
		$data = empty($data) ? '' : http_build_query($data);
		$param = $url.'?'.$data;
file_put_contents(DEBUG_CURL_LOG, Myfun::generateLogTime().' my_vgetbus => param => '. $param ."\n", FILE_APPEND);
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $param); // 要访问的地址
		curl_setopt($curl, CURLOPT_TIMEOUT, CURL_TIMEOUT); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		
		$ret = array();
		$ret['curl_res'] = curl_exec($curl); // 执行操作
		$ret['curl_err'] = curl_errno($curl); // 获取错误码
		//if (curl_errno($curl)) {
		//   file_put_contents('curl_error.log', 'Errno'.curl_error($curl), FILE_APPEND);//捕抓异常
		//}
		curl_close($curl); // 关闭CURL会话
		return $ret; // 返回数据
	}
	
	// get请求
	public static function my_vget($url, $data='', $cookie_name = '', $referer=CURL_REFERER, $proxy_enable = PROXY_ENABLE){ // 模拟提交数据函数
		$data = empty($data) ? '' : http_build_query($data);
	//var_dump($data);
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url.'?'.$data); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_USERAGENT, CURL_USER_AGENT); // 模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		//curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		curl_setopt($curl, CURLOPT_TIMEOUT, CURL_TIMEOUT); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		
		if (!empty($cookie_name)) {
			curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_name);
		}
		curl_setopt($curl, CURLOPT_REFERER, $referer);

		if (!empty($proxy_enable)) {
			
			// 增加proxy代理信息
			// Modify by wangyang
			// 2016/06/13
			//$loginpassw = 'username:password';
			//$proxy_ip = 'ip';
			//$proxy_port = 'port';
			//$url = 'http://www.dianping.com';
			//curl_setopt($curl, CURLOPT_PROXYPORT, PROXY_PORT);
			//curl_setopt($curl, CURLOPT_PROXYTYPE, 'HTTP');
			//curl_setopt($curl, CURLOPT_PROXY, PROXY_IP);
			//curl_setopt($curl, CURLOPT_PROXYUSERPWD, PROXY_PASS);
		}

		$ret = array();
		$ret['curl_res'] = curl_exec($curl); // 执行操作
		$ret['curl_err'] = curl_errno($curl); // 获取错误码
		//if (curl_errno($curl)) {
		//   file_put_contents('curl_error.log', 'Errno'.curl_error($curl), FILE_APPEND);//捕抓异常
		//}
		curl_close($curl); // 关闭CURL会话
		return $ret; // 返回数据
	}
	
	// 存储cookie + 获取cookie
	public static function my_vcget($url, $data='', $cookie_name='', $referer=CURL_REFERER, $proxy_enable = PROXY_ENABLE){ // 模拟提交数据函数
		$data = empty($data) ? '' : http_build_query($data);
	//var_dump($data);
		$curl = curl_init(); // 启动一个CURL会话
		curl_setopt($curl, CURLOPT_URL, $url.'?'.$data); // 要访问的地址
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
		curl_setopt($curl, CURLOPT_USERAGENT, CURL_USER_AGENT); // 模拟用户使用的浏览器
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
		//curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
		curl_setopt($curl, CURLOPT_TIMEOUT, CURL_TIMEOUT); // 设置超时限制防止死循环
		curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
		curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie_name);
		curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie_name);
		curl_setopt($curl, CURLOPT_REFERER, $referer);

		if (!empty($proxy_enable)) {
			
			// 增加proxy代理信息
			// Modify by wangyang
			// 2016/06/13
			//$loginpassw = 'username:password';
			//$proxy_ip = 'ip';
			//$proxy_port = 'port';
			//$url = 'http://www.dianping.com';
			curl_setopt($curl, CURLOPT_PROXYPORT, PROXY_PORT);
			curl_setopt($curl, CURLOPT_PROXYTYPE, 'HTTP');
			curl_setopt($curl, CURLOPT_PROXY, PROXY_IP);
			curl_setopt($curl, CURLOPT_PROXYUSERPWD, PROXY_PASS);
		}

		$ret = array();
		$ret['curl_res'] = curl_exec($curl); // 执行操作
		$ret['curl_err'] = curl_errno($curl); // 获取错误码
		//if (curl_errno($curl)) {
		//   file_put_contents('curl_error.log', 'Errno'.curl_error($curl), FILE_APPEND);//捕抓异常
		//}
		curl_close($curl); // 关闭CURL会话
		return $ret; // 返回数据
	}

	// 获取指定日期，返回date形式，例如：2016-06-30
	public static function my_getSpecificDate($offset = 0){ // 模拟提交数据函数

		if (!is_numeric($offset)) {
			$offset = 0;
		}
		return date('Y-m-d', strtotime($offset." day"));
	}
} 