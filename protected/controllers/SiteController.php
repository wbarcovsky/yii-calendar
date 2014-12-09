<?php

class SiteController extends BaseController
{

	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * Displays the login/register page and do login/register users
	 */
	public function actionLogin()
	{
		if ( ! isset($_POST['email']))
		{
			$this->render('login-view');
		}
		else
		{
			if ( ! isset($_POST['password'])) // Show new data fields
			{
				$action = '';
			}
			elseif (isset($_POST['repeat_password'])) // Show new data fields
			{
				$action = FormLogin::ACTION_REGISTER;
			}
			else
			{
				$action = FormLogin::ACTION_LOGIN;
			}

			$form = new FormLogin($action);
			$form->attributes = $_POST;

			if ($form->validate() && $action === FormLogin::ACTION_REGISTER)
			{
				$form->register();
			}

			if ($form->hasErrors())
			{
				Ajax::warning($form->firstError());
			}

			if ($action === '')
			{
				if ($form->email_registred())
				{
					Ajax::custom('show_login');
				}
				else
				{
					Ajax::custom('show_register');
				}
			}
			if ($action === FormLogin::ACTION_REGISTER)
			Ajax::redirect('site/index');
		}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error)
		{
			if (Yii::app()->request->isAjaxRequest)
			{
				echo $error['message'];
			}
			else
			{
				$this->render('error', $error);
			}
		}
	}


	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}