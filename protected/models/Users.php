<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer  $id
 * @property string   $email
 * @property string   $password
 * @property Events[] $events
 */
class Users extends ActiveRecord
{

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email, password', 'length', 'max' => 255],
        ];
    }
    
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'events' => [self::HAS_MANY, 'Events', 'user_id']
        ];
    }

    /**
     * Regsiter new user in system
     * @param string $email
     * @param string $password password before md5 crypting
     * @return null|Users Returns created user on NULL if fails
     */
    public static function register($email, $password)
    {
        $user           = new Users();
        $user->email    = $email;
        $user->password = md5($password);
        if ($user->save()) {
            return $user;
        }
        return null;
    }
    
    /**
     * Finds user by email
     * @param sting $email
     * @return Users|NULL returns NULL if fails to search
     */
    public static function findUserByEmail($email)
    {
        return Users::model()->find('LOWER(email)=?', [strtolower($email)]);
    }
    
    /**
     * returns all users except current
     * @return $this
     */
    public function other_users()
    {
        if (Yii::app()->user->isGuest) {
            return $this;
        }
        $this->getDbCriteria()->mergeWith([
            'condition' => 'id <> :id',
            'params' => ['id' => Yii::app()->user->profile->id],
        ]);
        return $this;
    }
}
