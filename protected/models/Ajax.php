<?php

/**
 * Class Ajax
 * Helper for ajax controllers
 * You can use only one ajax-function per action
 */
class Ajax
{
	/**
	 * Shows message alert
	 * @param string $text
	 */
	public static function message($text)
	{
		self::custom('swal', $text);
	}

	/**
	 * Shows warning message
	 * @param $text
	 */
	public static function warning($text)
	{
		self::custom('warning', $text);
	}

	/**
	 * Reload client page
	 */
	public static function reload()
	{
		self::custom('reload');
	}

	/**
	 * Redirect to another page
	 * @param string $url
	 */
	public static function redirect($url)
	{
		self::custom('redirect', Yii::app()->createUrl($url));
	}

	/**
	 * Execute custom js function on client side
	 * @param string     $func_name
	 * @param null|mixed $data
	 */
	public static function custom($func_name, $data = NULL)
	{
		$json['function'] = $func_name;
		if ( ! is_null($data))
		{
			$json['data'] = $data;
		}
		print json_encode($json);
		exit();
	}
}