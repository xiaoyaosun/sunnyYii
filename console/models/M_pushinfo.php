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
class M_pushinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_wf_user_task';
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
		$query = M_pushinfo::find()
			->where(['USER_ID' => $userID])
			->one();

		return $query;
    }
	
   /*
     * 根据用户Id，行程信息，删除push
     */
	// 物理删除
    //public static function deletePush($userID, $station_train_code, $start_train_date_page) {
	//	$del = M_pushinfo::deleteAll('USER_ID = :USER_ID AND train_code = :train_code AND start_time = :start_time', ['USER_ID' => $userID, 'train_code' => $station_train_code, 'start_time' => $start_train_date_page]);
	//	return $del;
    //}
	
	
	// 逻辑删除，status = 9代表删除
    public static function deletePush($userID, $station_train_code, $start_train_date_page) {
		
		// 前面是要改变成的值，后面是where条件
		$del = M_pushinfo::updateAll(['status' => 9], ['USER_ID' => $userID, 'train_code' => $station_train_code, 'start_time' => $start_train_date_page]);
		return $del;
    }
	
	// 根据主键id，逻辑删除，status = 9代表删除
    public static function deletePushByID($ID) {

		// 前面是要改变成的值，后面是where条件
		$del = M_pushinfo::updateAll(['status' => 9], ['id' => $ID]);
		return $del;
    }
	
    /*
     * 登录后存储用户信息
     */
	public static function savePushInfo($p) {
		
		$now = date('Y-m-d H:i:s', time());
		$model = new M_pushinfo();
		$model->USER_ID = $p['userID'];
		$model->station_name = $p['station_name'];
		$model->reminder_time = $p['reminder_time'];
		$model->template_id = $p['template_id'];
		$model->status = $p['status'];
		$model->train_code = $p['train_code'];
		$model->duration_value = $p['duration_value'];
		$model->start_time = $p['start_time'];
		$model->arriving_time = $p['arriving_time'];
		$model->last_create_time = $now;
		$model->last_update_time = $now;

		if ($model->save()) {
			return true;
		} else {
            MyLog::log(''.var_export($model->errors,true));
			return false;
		}
	}

    //获取所有的过时信息  status=9
    public static function  getOldMessage()
    {

        $time = time() - 3600 * 24 * 3;
        $time = date('Y-m-d H:i:s',$time);
        $query = M_pushinfo::find()
            ->where(['status' => 9])
            ->andWhere(['<','reminder_time',$time])
            ->orderby('id ASC')
            ->all();

        return $query;
    }

    /*
     *  根据数据物理删除数据
     *
     */
    public static function deleteByArray($array = array()) {
        if (empty($array)) {
            return false;
        }
        $query = M_pushinfo::find()
            ->where($array)
            ->one()
            ->delete();
        return $query;
    }

}
