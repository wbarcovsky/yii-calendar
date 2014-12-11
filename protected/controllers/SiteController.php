<?php

class SiteController extends BaseController
{

	public function actionIndex()
	{
		$data['events'] = Events::model()->findAllByAttributes(array('user_id' => $this->user->profile->id));
		$data['others'] = Users::model()->other_users()->findAll();
		$this->render('index-view', $data);
	}

	public function actionEditEvent()
	{
		try
		{
			$data = $_POST;
			if ( ! empty($data['event_id']))
			{
				$event = Events::model()->findByPk($data['event_id']);
			}
			else
			{
				$event = new Events();
			}
			unset($data['event_id']);
			$event->attributes = $data;
			$event->user_id = $this->user->profile->id;
			if ( ! $event->save())
			{
				Ajax::warning($event->firstError())	;
			}
			//Ajax::custom('update_events', json_encode($this->user->profile->events));
			Ajax::message('OK!');
		}
		catch (Exception $e)
		{
			Ajax::warning($e->getMessage());
		}

	}

	/**
	 * Displays the login/register page and do login/register users
	 */
	public function actionLogin()
	{
		if ( ! isset($_POST['action']))
		{
			$this->render('login-view');
		}
		else
		{
			try
			{
				$action = $_POST['action'];

				if ( ! in_array($action, array(FormLogin::ACTION_CHECK, FormLogin::ACTION_REGISTER, FormLogin::ACTION_LOGIN)))
				{
					throw new HttpException('Wrong input data!');
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

				if ($action === FormLogin::ACTION_CHECK) // Shows fields for register or sing in
				{
					if (is_null(Users::findUserByEmail($form->email)))
					{
						Ajax::custom('show_register');
					}
					else
					{
						Ajax::custom('show_login');
					}
				}
				else
				{
					Ajax::redirect('site/index');
				}
			}
			catch (Exception $e)
			{
				Ajax::warning($e->getMessage());
			}
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