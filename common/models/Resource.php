<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "resource".
 *
 * @property integer $id
 * @property string $type
 * @property string $category
 * @property integer $event_id
 * @property integer $upload_user_id
 * @property string $name
 * @property string $description
 * @property string $path
 * @property string $create_time
 *
 * @property Event $event
 */
class Resource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resource';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'upload_user_id'], 'required'],
            [['event_id', 'upload_user_id'], 'integer'],
            [['create_time'], 'safe'],
            [['type', 'category'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 256],
            [['path'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'category' => Yii::t('app', 'Category'),
            'event_id' => Yii::t('app', 'Event ID'),
            'upload_user_id' => Yii::t('app', 'Upload User ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'path' => Yii::t('app', 'Path'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }
}
