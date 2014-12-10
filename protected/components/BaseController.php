<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class BaseController extends CController
{
	/** @var string tag <title> of the page  */
	public $pageTitle;

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/column1';

	/** @var CClientScript */
	public $client_script;

	/** @var Identity Current logged user. NULL is not logged */
	public $user = NULL;

	public function beforeAction($action)
	{
		$this->client_script = Yii::app()->clientScript;

		if (Yii::app()->user->isGuest && Yii::app()->controller->action->id !== 'login')
		{
			$this->redirect(Yii::app()->createUrl('site/login'));
		}
		else
		{
			$this->user = Yii::app()->user;
		}

		return parent::beforeAction($action);
	}
}
