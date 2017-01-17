<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property string $title
 * @property string $location
 * @property string $start_time
 * @property string $end_time
 * @property boolean $all_day_event
 * @property string $description
 * @property integer $organizer
 * @property string $status
 * @property string $directory
 * @property integer $min_people
 * @property integer $max_people
 * @property string $type
 * @property string $create_time
 * @property string $contact
 *
 * @property Comment[] $comments
 * @property User $organizer0
 * @property EventCategory[] $eventCategories
 * @property EventInvitationCode[] $eventInvitationCodes
 * @property Notification[] $notifications
 * @property Resource[] $resources
 * @property UserEvent[] $userEvents
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'location', 'start_time'], 'required'],
            [['start_time', 'end_time', 'create_time'], 'safe'],
            [['all_day_event'], 'boolean'],
            [['organizer', 'min_people', 'max_people'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['location'], 'string', 'max' => 256],
            [['description'], 'string', 'max' => 2048],
            [['status', 'type'], 'string', 'max' => 32],
            [['directory'], 'string', 'max' => 64],
            [['contact'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'location' => Yii::t('app', 'Location'),
            'start_time' => Yii::t('app', 'Start Time'),
            'end_time' => Yii::t('app', 'End Time'),
            'all_day_event' => Yii::t('app', 'All Day Event'),
            'description' => Yii::t('app', 'Description'),
            'organizer' => Yii::t('app', 'Organizer'),
            'status' => Yii::t('app', 'Status'),
            'directory' => Yii::t('app', 'Directory'),
            'min_people' => Yii::t('app', 'Min People'),
            'max_people' => Yii::t('app', 'Max People'),
            'type' => Yii::t('app', 'Type'),
            'create_time' => Yii::t('app', 'Create Time'),
            'contact' => Yii::t('app', 'Contact'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizer0()
    {
        return $this->hasOne(User::className(), ['id' => 'organizer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventCategories()
    {
        return $this->hasMany(EventCategory::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventInvitationCodes()
    {
        return $this->hasMany(EventInvitationCode::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notification::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResources()
    {
        return $this->hasMany(Resource::className(), ['event_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEvents()
    {
        return $this->hasMany(UserEvent::className(), ['event_id' => 'id']);
    }
}
