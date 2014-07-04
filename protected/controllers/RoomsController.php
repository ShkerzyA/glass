<?php

class RoomsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	
	public $events_menu=array(
		array('name'=>'События','type'=>'events','rule'=>NULL),
		array('name'=>'План операций','type'=>'eventsOpPl','rule'=>'operationSV'),
		array('name'=>'Мониторинг операций','type'=>'eventsOpMon','rule'=>NULL)
		);

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}


	public function mayShow($rule){
		if(empty($rule)){
			return true;
		}else{
			return Yii::app()->user->checkAccess($rule,array()); 
		}

	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','show'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete'),
				'roles'=>array('moderator'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'roles'=>array('administrator'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Rooms;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Rooms']))
		{
			$model->attributes=$_POST['Rooms'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	public function actionShow($id=NULL){
		$this->layout='//layouts/column1';


		if($id!=NULL){
			Yii::app()->session['Rooms_id']=$id;
		}else if(empty(Yii::app()->session['Rooms_id'])){
			Yii::app()->session['Rooms_id']=0;
		}

		if(!empty($_GET['date'])){
			Yii::app()->session['Rooms_date']=new DateTime($_GET['date']);
		}else if(empty(Yii::app()->session['Rooms_date'])){
			Yii::app()->session['Rooms_date']=new DateTime(date('Y-m-d'));
		}

		if(!empty($_GET['Show_type'])){
			Yii::app()->session['Show_type']=$_GET['Show_type'];
		}else if(empty(Yii::app()->session['Show_type'])){
			Yii::app()->session['Show_type']='week';
		}

		if(!empty($_GET['Event_type'])){
			Yii::app()->session['Event_type']=$_GET['Event_type'];
		}else if(empty(Yii::app()->session['Event_type'])){
			Yii::app()->session['Event_type']='events';
		}

		if(!empty(Yii::app()->session['Rooms_id'])){
			$model=Rooms::model()->findByPk(Yii::app()->session['Rooms_id']);
		}else{
			$model=new Rooms();
		}
	
		$week=array();
		$rooms=$model->getRooms(Yii::app()->session['Event_type']);
		
		switch (Yii::app()->session['Event_type']) {
			case 'events':
					$event=new Events;
				break;
			case 'eventsOpPl':
			case 'eventsOpMon':
					$event=new Eventsoper;
				break;
			
			default:
					$event=new Events;
				break;

		}

		$res=$event->findEvents(Yii::app()->session['Show_type'],Yii::app()->session['Rooms_date']);

		$events=$res['events'];
		$week=$res['week'];
		
		$this->render('show',array(
			'model'=>$model,'roomsM'=>$rooms,'events'=>$events,'week'=>$week
		));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Rooms']))
		{
			$model->attributes=$_POST['Rooms'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Rooms');
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'modelLabelP'=>Rooms::$modelLabelP,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Rooms('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Rooms']))
			$model->attributes=$_GET['Rooms'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Rooms the loaded model
	 * @throws CHttpException
	 */

	public function loadModel($id)
	{
		$model=Rooms::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Rooms $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rooms-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
