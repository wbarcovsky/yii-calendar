<?php

class ActiveRecord extends CActiveRecord
{
    use ModelTrait;


    /**
     * @see CActiveRecord::model()
     * @param $className string
     * @return $this
     */
    public static function model($className = null)
    {
        if ($className === null) {
            $className = get_called_class();
        }

        return parent::model($className);
    }

    /**
     * @see CActiveRecord::tableName()
     */
    public function tableName()
    {
        return strtolower(get_class($this));
    }
}