<?php

/**
 * This is the model class for table "events".
 *
 * The followings are the available columns in table 'events':
 * @property integer $id
 * @property integer $user_id
 * @property integer $attach_user
 * @property string $title
 * @property string $text
 * @property string $date
 * @property integer $time_hour
 */
class Events extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, date, time_hour, title', 'required'),
			array('user_id, time_hour, attach_user', 'numerical', 'integerOnly' => TRUE),
			array(
				'attach_user',
				'compare',
				'allowEmpty'       => TRUE,
				'compareAttribute' => 'user_id',
				'operator'         => '!=',
				'message'          => 'You cannot attach your self to the event!'
			),
			array('title', 'length', 'max' => 100),
			array('type', 'length', 'max' => 100),
			array('text', 'length', 'max' => 500),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id'   => 'User',
			'title'     => 'Title',
			'text'      => 'Text',
			'date'      => 'Date of Event',
			'time_hour' => 'Hour of Event',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Events the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function allErrors()
	{
		$s = array();
		foreach ($this->errors as $errors)
		{
			foreach ($errors as $error)
			{
				$s[] = $error;
			}
		}
		return $s;
	}

	public function firstError()
	{
		$errors = $this->allErrors();
		return current($errors);
	}

	/**
	 * Returns all events for current logged user
	 * @return Events[]
	 */
	/**
	 * returns all users except current
	 * @return $this
	 */
	public function for_this_user()
	{
		if (Yii::app()->user->isGuest)
		{
			return NULL;
		}
		$this->getDbCriteria()->mergeWith(array(
			'condition' => 'user_id = ' . Yii::app()->user->profile->id,
		));
		return $this;
	}
}