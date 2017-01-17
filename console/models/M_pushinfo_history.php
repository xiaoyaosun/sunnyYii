<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "t_wf_user_task".
 *
 * @property integer $id
 * @property string $USER_ID
 * @property string $station_name
 * @property string $reminder_time
 * @property integer $template_id
 * @property integer $status
 * @property string $train_code
 * @property string $duration_value
 * @property string $start_time
 * @property string $arriving_time
 */
class M_pushinfo_history extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_wf_user_task_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USER_ID', 'station_name', 'template_id', 'status', 'train_code', 'duration_value'], 'required'],
            [['template_id', 'status'], 'integer'],
            [['reminder_time', 'start_time', 'arriving_time', 'last_create_time', 'last_update_time'], 'safe'],
            [['USER_ID'], 'string', 'max' => 32],
            [['station_name'], 'string', 'max' => 50],
            [['train_code'], 'string', 'max' => 10],
            [['duration_value'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'USER_ID' => Yii::t('app', '用户ID'),
            'station_name' => Yii::t('app', '站名'),
            'reminder_time' => Yii::t('app', '消息提醒时间'),
            'template_id' => Yii::t('app', '消息提醒模板ID'),
            'status' => Yii::t('app', '发送状态'),
            'train_code' => Yii::t('app', '车次'),
            'duration_value' => Yii::t('app', 'Duration Value'),
            'start_time' => Yii::t('app', 'Start Time'),
            'arriving_time' => Yii::t('app', 'Arriving Time'),
			'last_create_time' => Yii::t('app', '创建时间'),
			'last_update_time' => Yii::t('app', '更新时间'),
        ];
    }
	
   /*
     * 根据用户Id获取用户基本信息
     */
    public static function findByUserID($userID) {
		$query = M_pushinfo_history::find()
			->where(['USER_ID' => $userID])
			->one();

		return $query;
    }
	
    /*
     * 登录后存储用户信息
     */
	public static function savePushInfo($p) {
		
		$model = new M_pushinfo_history();
        $model->id = $p['id'];
		$model->USER_ID = $p['USER_ID'];
		$model->station_name = $p['station_name'];
		$model->reminder_time = $p['reminder_time'];
		$model->template_id = $p['template_id'];
		$model->status = $p['status'];
		$model->train_code = $p['train_code'];
		$model->duration_value = $p['duration_value'];
		$model->start_time = $p['start_time'];
		$model->arriving_time = $p['arriving_time'];
		$model->last_create_time = $p['last_create_time'];
		$model->last_update_time = $p['last_update_time'];

		if ($model->save()) {
			return true;
		} else {
            MyLog::log(''.var_export($model->errors,true));
			return false;
		}
	}
}
