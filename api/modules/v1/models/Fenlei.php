<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "fenlei".
 *
 * @property string $id
 * @property integer $type
 * @property string $name
 * @property integer $paper_id
 * @property integer $count
 * @property string $prefix
 * @property string $output
 * @property string $create_time
 * @property string $update_time
 * @property string $ext
 */
class Fenlei extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fenlei';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name', 'paper_id', 'count', 'prefix', 'output', 'create_time', 'update_time', 'ext'], 'required'],
            [['type', 'paper_id', 'count'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['prefix'], 'string', 'max' => 20],
            [['output'], 'string', 'max' => 10],
            [['ext'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', ''),
            'name' => Yii::t('app', ''),
            'paper_id' => Yii::t('app', ''),
            'count' => Yii::t('app', ''),
            'prefix' => Yii::t('app', ''),
            'output' => Yii::t('app', 'json或html'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'ext' => Yii::t('app', 'Ext'),
        ];
    }
	
	public static function findInfoByTypeID($p) {
		$query = Fenlei::find()
			->where(['type' => $p['type']])
			->offset($p['page'])
			->limit($p['limit'])
			->orderby('id asc')
			->all();
		return $query;
	}
}
