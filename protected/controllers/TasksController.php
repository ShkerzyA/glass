<?php

class TasksController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','helpDesk','saveMessage','saveStatus'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles'=>array('user'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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

		Yii::app()->session['Task_id']=$id;
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
		$model=new Tasks;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tasks']))
		{
			$model->attributes=$_POST['Tasks'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionSaveMessage(){
		if(Yii::app()->request->isAjaxRequest){
			$model=new TasksActions;	
			echo $_POST['mess'];
			
			$model->ttext=$_POST['mess'];
			$model->type=1;
			$model->id_task=Yii::app()->session['Task_id'];

			$model->save();
		}
	}	

	public function actionSaveStatus(){
		if(Yii::app()->request->isAjaxRequest){


			$model=Tasks::model()->findByPk(Yii::app()->session['Task_id']);
			$model_act=new TasksActions;	
			echo $_POST['stat'];
			$model->status=$_POST['stat'];

			if(($_POST['stat']==1) and(empty($model->executor))){
				$model->executor=Yii::app()->user->id_posts[0];
			}


			$model->save();
			
			$model_act->ttext=$_POST['stat'];
			$model_act->type=0;
			$model_act->id_task=Yii::app()->session['Task_id'];

			$model_act->save();
		}
	}	

		public function actionCreateActions()
	{
		$model=new TasksActions;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TasksActions']))
		{
			$model->attributes=$_POST['TasksActions'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('createactions',array(
			'model'=>$model,
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

		if(isset($_POST['Tasks']))
		{
			$model->attributes=$_POST['Tasks'];
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

	public function actionHelpDesk($id_department,$status='4'){
		$this->layout='//layouts/column1';

		$fu=new TasksActions;

		//echo'<pre>';
		//print_r($fu);
		//echo'</pre>';

		$model=Tasks::model()->findAll(array('condition'=>"id_department=".$id_department." and status not in (".$status.")"));
		$this->render('helpdesk',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Tasks');
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'modelLabelP'=>Tasks::$modelLabelP,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tasks('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tasks']))
			$model->attributes=$_GET['Tasks'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tasks the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tasks::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tasks $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tasks-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
