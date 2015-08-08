<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class Identity extends CUserIdentity
{
	/** @var Users users's data from DB */
	public $profile;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$res = Users::model()->find('LOWER(email)=? AND password=MD5(?)', [strtolower($this->username), $this->password]);
		if ( ! $res)
		{
			return FALSE;
		}
		$this->profile = $res;
		$this->setState('profile', $res);
		$duration = 3600*24*10; // 10 days
		Yii::app()->user->login($this, $duration);
		return TRUE;
	}
}