<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

public function actionInstall(){
	$auth=Yii::app()->authManager;
    $auth->clearAll();
 
    //Операции управления пользователями.
    $auth->createOperation('index', 'Просмотр');
    $auth->createOperation('view', 'Просмотр');
    $auth->createOperation('create', 'Создать');
    $auth->createOperation('update', 'Создать');
    $auth->createOperation('admin', 'Создать');
    $auth->createOperation('delete', 'Создать');
    $auth->createOperation('save', 'Сохранить');
    $auth->createOperation('saveMessage', 'Сохранить Сообщение');
    $auth->createOperation('saveStatus', 'Изменить статус Задачи');
    $auth->createOperation('saveStatusEv', 'Изменить статус События');

 
    //$bizRule='return Yii::app()->user->id==Tasks::loadmodel()->$params["id"]->u_id;';
    //$task = $auth->createTask('OwnSaveMessage', 'изменение своих данных', $bizRule);
    //$task->addChild('saveMessage');


   	$bizRule='return (in_array($params["mod"]->id_department,Yii::app()->user->id_departments) and (empty($params["mod"]->group) or in_array($params["mod"]->group,Yii::app()->user->group)));';
    $task = $auth->createTask('OwnSaveStatus', 'Изменение своих задач', $bizRule);
    $task->addChild('saveStatus', 'Изменить статус');

    $bizRule='$params["mod"]->isChangeStatus();';
    $task = $auth->createTask('ManagerSaveStatusEv', 'Изменение подконтрольных событий', $bizRule);
    $task->addChild('saveStatusEv', 'Изменить статус');

    $guest = $auth->createRole('guest');
	$guest->addChild('index');
	$guest->addChild('view');    

    $user = $auth->createRole('user');
    $user->addChild('guest');
    $user->addChild('create');
  	$user->addChild('saveMessage');
  	$user->addChild('OwnSaveStatus');
  	$user->addChild('ManagerSaveStatusEv');

    $moderator = $auth->createRole('moderator');
    $moderator->addChild('user');
    $moderator->addChild('update');
    $moderator->addChild('save');
    $moderator->addChild('saveStatus'); 
    $moderator->addChild('saveStatusEv'); 


    $administrator = $auth->createRole('administrator');
    $administrator->addChild('moderator');
    $administrator->addChild('admin');
    $administrator->addChild('delete');


	//Тут добавляется тот функционал, который не укладывается в общую пирамиду наследования  

    $auth->save();
 
    $this->render('install');
}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->render('error',array('message'=>'Пройдите авторизацию'));
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