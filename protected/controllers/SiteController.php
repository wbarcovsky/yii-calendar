<?php

class SiteController extends BaseController
{

    public function actionIndex()
    {
        $data['events'] = Events::model()->for_this_user()->findAll();
        $data['others'] = Users::model()->other_users()->findAll();
        $this->render('index-view', $data);
    }

    public function actionEditEvent()
    {
        try {
            $data = $_POST;
            if ( !empty($data['event_id'])) {
                $event = Events::model()->for_this_user()->findByPk($data['event_id']);
                if (empty($event)) {
                    Ajax::warning('Cannot find requested item!');
                }

            } else {
                $event = new Events();
            }
            unset($data['event_id']);
            $event->attributes = $data;
            $event->user_id    = $this->user->profile->id;
            if ( !$event->save()) {
                Ajax::warning($event->firstError());
            }
            $events = Events::model()->for_this_user()->findAll();
            Ajax::custom('upload_events', Ajax::modelToJson($events));
        } catch (Exception $e) {
            Ajax::warning($e->getMessage());
        }
    }

    public function actionRemoveEvent()
    {
        try {
            $id = intval($_POST['id']);

            $event = Events::model()->for_this_user()->findByPk($id);
            if ( !$event->delete()) {
                Ajax::message($event->firstError());
            }
            $events = Events::model()->for_this_user()->findAll();
            Ajax::custom('remove_events', Ajax::modelToJson($events));
        } catch (Exception $e) {
            Ajax::warning($e->getMessage());
        }
    }

    /**
     * Displays the login/register page and do login/register users
     */
    public function actionLogin()
    {
        if ( !isset($_POST['action'])) {
            $this->render('login-view');
        } else {
            try {
                $action = $_POST['action'];

                if ( !in_array($action, [FormLogin::ACTION_CHECK, FormLogin::ACTION_REGISTER, FormLogin::ACTION_LOGIN])) {
                    throw new HttpException('Wrong input data!');
                }

                $form             = new FormLogin($action);
                $form->attributes = $_POST;

                if ($form->validate() && $action === FormLogin::ACTION_REGISTER) {
                    $form->register();
                }

                if ($form->hasErrors()) {
                    Ajax::warning($form->firstError());
                }

                if ($action === FormLogin::ACTION_CHECK) // Shows fields for register or sing in
                {
                    if (is_null(Users::findUserByEmail($form->email))) {
                        Ajax::custom('show_register');
                    } else {
                        Ajax::custom('show_login');
                    }
                } else {
                    Ajax::redirect('site/index');
                }
            } catch (Exception $e) {
                Ajax::warning($e->getMessage());
            }
        }
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                Ajax::warning($error);
            } else {
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