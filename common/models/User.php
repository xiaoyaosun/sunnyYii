<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $address
 * @property boolean $sex
 * @property string $image
 * @property boolean $active
 * @property boolean $verified
 * @property integer $level
 * @property string $wechat_id
 * @property string $email
 * @property string $create_time
 * @property string $last_update_time
 * @property string $last_login_time
 * @property string $token
 *
 * @property Comment[] $comments
 * @property Contact[] $contacts
 * @property Event[] $events
 * @property UserHobby[] $userHobbies
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
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
            [['username', 'password'], 'required'],
            [['sex', 'active', 'verified'], 'boolean'],
            [['level'], 'integer'],
            [['create_time', 'last_update_time', 'last_login_time'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['password', 'wechat_id', 'email', 'qq_id', 'sina_weibo_id'], 'string', 'max' => 64],
            [['address','username'], 'string', 'max' => 128],
            [['image'], 'string', 'max' => 1024],
            [['token', 'city', 'phone'], 'string', 'max' => 45],
            [['device_token'], 'string', 'max' => 100],
            [['username'], 'unique'],
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
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'name' => Yii::t('app', 'Name'),
            'address' => Yii::t('app', 'Address'),
            'sex' => Yii::t('app', 'Sex'),
            'image' => Yii::t('app', 'Image'),
            'active' => Yii::t('app', 'Active'),
            'verified' => Yii::t('app', 'Verified'),
            'level' => Yii::t('app', 'Level'),
            'wechat_id' => Yii::t('app', 'Wechat ID'),
            'email' => Yii::t('app', 'Email'),
            'create_time' => Yii::t('app', 'Create Time'),
            'last_update_time' => Yii::t('app', 'Last Update Time'),
            'last_login_time' => Yii::t('app', 'Last Login Time'),
            'token' => Yii::t('app', 'Token'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contact::className(), ['contact_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['organizer' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserHobbies()
    {
        return $this->hasMany(UserHobby::className(), ['user_id' => 'id']);
    }

    public static function findByUsername($username)
	{
	     return static::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
	    return $this->password === $password;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

     public static function findIdentityByAccessToken($token, $type = null)
     {
         return static::findOne(['token' => $token]);
     }

      public function getId()
      {
          return $this->id;
      }

      public function getAuthKey()
      {
          return $this->token;
      }

      public function validateAuthKey($authKey)
      {
          return $this->token === $authKey;
      }
}
