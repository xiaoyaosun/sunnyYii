<?php
/***************************************************************************
 * 
 * Author: xiaoyaosun@qq.com
 * Date:    2016-07-20
 * Desc:    AES加密解密
 **************************************************************************/
namespace api\components;

use Yii;

class Myencrypt {

	// Modify by wangyang
	// 2016/07/20
	// 支持JAVA，不改JDK，因此截断为128位
	const MY_ENCRYPT_KEY = 'XXXXXXXXXXXXXXXX'; // 设置为自己的加密key

	// 敏感数据解密
	public static function decrypt($encryptText, $key = self::MY_ENCRYPT_KEY) {

		$cryptText = pack ("H*", $encryptText );
		$ivSize = mcrypt_get_iv_size ( MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB );
		$iv = mcrypt_create_iv ( $ivSize, MCRYPT_RAND );
		$decryptText = mcrypt_decrypt ( MCRYPT_RIJNDAEL_128, $key, $cryptText, MCRYPT_MODE_ECB, $iv );
		return trim ( $decryptText );
	}

	// 敏感数据加密
	public static function encrypt($plainText, $key = self::MY_ENCRYPT_KEY) {

		$ivSize = mcrypt_get_iv_size ( MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB );
		$iv = mcrypt_create_iv ( $ivSize, MCRYPT_RAND );
		$encryptText = mcrypt_encrypt ( MCRYPT_RIJNDAEL_128, $key, $plainText, MCRYPT_MODE_ECB, $iv );
		return trim ( bin2hex($encryptText) );
	}
}
