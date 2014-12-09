<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class BaseController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/column1';

	/** @var CClientScript */
	public $client_script;

	public function beforeAction($action)
	{
		$this->client_script = Yii::app()->clientScript;
		if (Yii::app()->user->isGuest && Yii::app()->controller->action->id !== 'login')
		{
			$this->redirect(Yii::app()->createUrl('site/login'));
		}

		return parent::beforeAction($action);
	}
}
