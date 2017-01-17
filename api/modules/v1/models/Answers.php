<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "answers".
 *
 * @property integer $id
 * @property integer $question_id
 * @property string $title
 * @property string $img
 * @property string $options
 * @property string $created_at
 * @property string $updated_at
 * @property integer $is_deleted
 * @property integer $answers_id
 * @property string $create_time
 * @property string $update_time
 * @property string $ext
 * @property integer $ext_status
 */
class Answers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paper_id', 'question_id', 'is_deleted', 'answers_id', 'ext_status'], 'integer'],
            [['options', 'answers_id'], 'required'],
            [['create_time', 'update_time'], 'safe'],
            [['title'], 'string', 'max' => 200],
            [['img', 'ext'], 'string', 'max' => 100],
            [['options'], 'string', 'max' => 5],
            [['created_at', 'updated_at'], 'string', 'max' => 50],
            [['answers_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
			'paper_id' => Yii::t('app', ' ID'),
            'question_id' => Yii::t('app', ' ID'),
            'title' => Yii::t('app', 'Title'),
            'img' => Yii::t('app', 'Img'),
            'options' => Yii::t('app', 'Options'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'answers_id' => Yii::t('app', ''),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'ext' => Yii::t('app', 'Ext'),
            'ext_status' => Yii::t('app', 'Ext Status'),
        ];
    }
	
    public static function findInfoByID($p) {
		$query = Answers::find()
			->where(['paper_id' => $p['paper_id'], 'question_id' => $p['question_id']])
			->all();
		return $query;
    }
}
