<?php

/**
 * This is the model class for table "events".
 *
 * The followings are the available columns in table 'events':
 * @property integer $id
 * @property integer $user_id
 * @property integer $attach_user
 * @property string  $title
 * @property string  $text
 * @property string  $date
 * @property integer $time_hour
 */
class Events extends ActiveRecord
{
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['user_id, date, time_hour, title', 'required'],
            ['user_id, time_hour, attach_user', 'numerical', 'integerOnly' => true],
            [
                'attach_user',
                'compare',
                'allowEmpty'       => true,
                'compareAttribute' => 'user_id',
                'operator'         => '!=',
                'message'          => 'You cannot attach your self to the event!'
            ],
            ['title, type', 'length', 'max' => 100],
            ['text', 'length', 'max' => 500],
            ['date', 'uniqueDateTime'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [];
    }

    /**
     * Validate rule for event attribute
     * @param $attribute
     * @param $params
     */
    public function uniqueDateTime($attribute, $params)
    {
        $events = self::model()->findAllByAttributes([
            'time_hour' => $this->time_hour,
            'date'      => $this->date,
            'user_id'   => $this->user_id
        ]);

        if ( !empty($events)) {
            foreach ($events as $other_event) {
                if ($other_event->id != $this->id) {
                    $this->addError($attribute, 'You cannot place two event at the same date and time!');
                }
            }
        }
    }

    /**
     * returns all event for logged user
     * @return $this
     */
    public function for_this_user()
    {
        if (Yii::app()->user->isGuest) {
            return null;
        }
        $this->getDbCriteria()->mergeWith([
            'condition' => 'user_id = ' . Yii::app()->user->profile->id,
        ]);
        return $this;
    }
}