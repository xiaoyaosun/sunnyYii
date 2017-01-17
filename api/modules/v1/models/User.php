<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $token
 * @property string $passwd
 * @property string $mobile
 * @property integer $status
 * @property integer $type
 * @property string $create_time
 * @property string $update_time
 * @property string $ext
 * @property string $nickname
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'type'], 'integer'],
            [['create_time', 'update_time'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['username', 'nickname'], 'string', 'max' => 45],
            [['token', 'passwd'], 'string', 'max' => 64],
            [['mobile'], 'string', 'max' => 20],
            [['ext'], 'string', 'max' => 100],
            [['token'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', '用户名'),
            'token' => Yii::t('app', '用户token'),
            'passwd' => Yii::t('app', '密码'),
            'mobile' => Yii::t('app', '用户登录手机号'),
            'status' => Yii::t('app', 'Status'),
            'type' => Yii::t('app', 'Type'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'ext' => Yii::t('app', '扩展'),
            'nickname' => Yii::t('app', '用户昵称'),
        ];
    }
	
   /*
     * 查找token
     */
    public static function checkToken($userID, $token)
    {
		$query = User::find()
			->where(['id' => $userID, 'token' => $token])
			->one();
			
		return $query;
    }
	
   /*
     * 查找用户信息
     */
    public static function findByUserID($userID)
    {
		$query = User::find()
			->where(['id' => $userID])
			->one();
			
		return $query;
    }
	
   /*
     * 查找白名单用户信息
     */
    public static function findWhiteByUserID($userID, $token, $type, $mobile)
    {
		$query = User::find()
			->where(['id' => $userID, 'token' => $token, 'type' => $type, 'mobile' => $mobile])
			->one();
			
		return $query;
    }
	
   /*
     * 更新用户为已授权用户
     */
    public static function updateWhiteUser($userID, $token, $type, $mobile)
    {
		
		$res = User::update(['status' => 1], ['id' => $userID, 'token' => $token, 'type' => $type, 'mobile' => $mobile]);
		return $res;
    }
	
   /*
     * 创建用户
     */
    public static function addNewUser($p)
    {
		$query = User::find()
			->where(['mobile' => $p['mobile']])
			->one();
		
		if (empty($query)) {
			
			// 新用户，则重新创建
			$user = new User();
			$user->token = strtoupper(md5(uniqid(rand(), true))); // 获取token值
			$user->mobile = $p['mobile'];
			$user->username = 'Music';
			$user->nickname = 'Music';
			$user->passwd = md5('xxx'.PASSWD_SALT); // 
			$user->create_time = date('Y-m-d H:i:s', time());
			$user->update_time = date('Y-m-d H:i:s', time());
			$user->type = isset($p['type']) ? $p['type'] : 0; // type=0，代表正常用户
			$user->status = isset($p['status']) ? $p['status'] : 0; // status=0，代表未授权用户，status=1，代表已授权用户，
			$user->ext = '';
			
			if ($user->save()) {
				
				$ret['userID'] = base64_encode($user->attributes['id']);
				$ret['token'] = base64_encode($user->token);
				return $ret;
			} else {
				return false;
			}
			
		} else {
			
			// 更新token，并返回信息
			$user = $query;
			$user->token = strtoupper(md5(uniqid(rand(), true))); // 获取token值
			$user->update_time = date('Y-m-d H:i:s', time());	if ($user->save()) {
				
				$ret['userID'] = base64_encode($user->id);
				$ret['token'] = base64_encode($user->token);
				return $ret;
			} else {
				return false;
			}
		}
		
		return false;
    }
}
