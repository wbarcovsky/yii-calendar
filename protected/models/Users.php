<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property Events[] $events
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('email', 'required'),
			array('email, password', 'length', 'max'=>255),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'events' => array(self::HAS_MANY, 'Events', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'email' => 'Email',
			'password' => 'Password',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Regsiter new user in system
	 * @param string $email
	 * @param string $password password before md5 crypting
	 * @return null|Users Returns created user on NULL if fails
	 */
	public static function register($email, $password)
	{
		$user = new Users();
		$user->email = $email;
		$user->password = md5($password);
		if ($user->save())
		{
			return $user;
		}
		return NULL;
	}

	/**
	 * Finds user by email
	 * @param sting $email
	 * @return Users|NULL returns NULL if fails to search
	 */
	public static function findUserByEmail($email)
	{
		return Users::model()->find('LOWER(email)=?', array(strtolower($email)));
	}

	/**
	 * returns all users except current
	 * @return $this
	 */
	public function other_users()
	{
		if ( Yii::app()->user->isGuest)
		{
			return $this;
		}
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'id <> ' . Yii::app()->user->profile->id,
		));
		return $this;
	}
}
