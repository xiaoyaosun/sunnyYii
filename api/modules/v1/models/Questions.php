<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "questions".
 *
 * @property integer $id
 * @property integer $paper_id
 * @property integer $question_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $is_deleted
 * @property string $area_id
 * @property string $title
 * @property integer $num
 * @property string $correct
 * @property integer $score
 * @property string $image
 * @property string $sound
 * @property string $titlesound
 * @property string $label
 * @property string $settings
 * @property integer $answers
 * @property string $create_time
 * @property string $update_time
 * @property string $ext
 * @property integer $ext_status
 */
class Questions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paper_id', 'question_id', 'title', 'num', 'answers'], 'required'],
            [['index', 'paper_id', 'question_id', 'is_deleted', 'num', 'score', 'answers', 'ext_status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['created_at', 'updated_at'], 'string', 'max' => 50],
            [['area_id'], 'string', 'max' => 45],
            [['title', 'settings'], 'string', 'max' => 200],
            [['correct', 'label'], 'string', 'max' => 10],
            [['image', 'sound', 'titlesound', 'ext'], 'string', 'max' => 100],
            [['question_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
			'index' => Yii::t('app', 'Index ID'),
            'paper_id' => Yii::t('app', 'Paper ID'),
            'question_id' => Yii::t('app', 'Question ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'area_id' => Yii::t('app', 'Area ID'),
            'title' => Yii::t('app', 'Title'),
            'num' => Yii::t('app', 'Num'),
            'correct' => Yii::t('app', 'Correct'),
            'score' => Yii::t('app', 'Score'),
            'image' => Yii::t('app', 'Image'),
            'sound' => Yii::t('app', 'Sound'),
            'titlesound' => Yii::t('app', 'Titlesound'),
            'label' => Yii::t('app', 'Label'),
            'settings' => Yii::t('app', 'Settings'),
            'answers' => Yii::t('app', ''),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
            'ext' => Yii::t('app', 'Ext'),
            'ext_status' => Yii::t('app', 'Ext Status'),
        ];
    }
	
	/*
     * 根据Id获取具体对应的题目
     */
    public static function findInfoByID($p) {
		$query = Questions::find()
			->where(['paper_id' => $p['paper_id'], 'question_id' => $p['question_id'], 'index' => $p['item_id']])
			->one();
		return $query;
    }
	
	/*
     * 根据Id获取具体对应的题目
     */
    public static function findInfoByPaperID($p) {
		$query = Questions::find()
			->select(['question_id', 'index', 'paper_id'])
			->where(['paper_id' => $p['paper_id']])
			->offset($p['page'])
			->limit($p['limit'])
			->orderby('index asc')
			->all();
		return $query;
    }
	
	/*
     * 根据Id获取具体对应的题目和答案
     */
    public static function findAnswerInfoByPaperID($p) {
		$query = Questions::find()
			->select(['question_id', 'index', 'paper_id', 'correct', 'score'])
			->where(['paper_id' => $p['paper_id']])
			->orderby('index asc')
			->all();
		return $query;
    }
}
