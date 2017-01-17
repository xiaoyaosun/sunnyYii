<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "t_wf_randcode".
 *
 * @property string $id
 * @property string $phone_num
 * @property string $randcode
 * @property string $last_create_time
 * @property string $status
 * @property int $type
 * @property string $ext
 */
class Randcode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'randcode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone_num', 'randcode'], 'required'],
            [['last_create_time'], 'safe'],
			[['type'], 'integer'],
            [['phone_num'], 'string', 'max' => 20],
            [['randcode'], 'string', 'max' => 10],
            [['status'], 'string', 'max' => 2],
            [['ext'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phone_num' => Yii::t('app', 'Phone Num'),
            'randcode' => Yii::t('app', 'Randcode'),
			'type' => Yii::t('app', '验证码类型'),
            'last_create_time' => Yii::t('app', 'Last Create Time'),
            'status' => Yii::t('app', 'Status'),
            'ext' => Yii::t('app', 'Ext'),
        ];
    }
	
   /*
     * 更新已使用的用户验证码
	 * type表示属于哪个类型的验证码
     */
    public static function updateByPhone($mobile, $type = 1)
    {
		$update = Randcode::updateAll(['status' => '1'], ['phone_num' => $mobile, 'type' => $type]);
			
		return $update;
    }
	
   /*
     * 删除用户验证码
     */
    public static function delByPhone($mobile, $type = 1)
    {
		$del = Randcode::deleteAll(['phone_num' => $mobile, 'type' => $type]);
			
		return $del;
    }
	
   /*
     * 根据用户Id获取用户验证码
     */
    public static function findByPhone($mobile, $type = 1)
    {
		$query = Randcode::find()
			->where(['phone_num' => $mobile, 'type' => $type])
			->orderby('id DESC')
			->one();
			
		return $query;
    }
	
    /*
     * 登录后存储用户信息
     */
	public static function saveRandCode($p) {

		$model = new Randcode();
		$model->phone_num = $p['mobile'];
		$model->randcode = $p['randcode'];
		$model->last_create_time = date('Y-m-d H:i:s', time());
		$model->type = isset($p['type']) ? $p['type'] : 1; // type=1代表app验证，type=2代表PC端登录验证
		$model->status = '0'; // status = 0, 未使用, status = 1，已使用
		$model->ext = '';
		
		if ($model->save()) {
			return true;
		} else {
			return false;
		}
	}
}
