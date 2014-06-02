<?php

class TasksController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $id_department;
	public $group;
	public $horn;
	public $isHorn;

	public $tasks_menu=array(
		array('name'=>'IT crowd','id_department'=>'1011','group'=>''),
		array('name'=>'Плотники','id_department'=>'1074','group'=>'carpenters'),
		array('name'=>'Сантехники','id_department'=>'1074','group'=>'plumbers'),
		array('name'=>'Электрики','id_department'=>'1074','group'=>'electricians'),
		array('name'=>'Вентиляция','id_department'=>'1074','group'=>'ventilation'),
		);

	public function init(){
		$this->horn=Yii::app()->request->baseUrl.'/media/tripod.ogg';
		$this->isHorn=false;
	}
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
				'actions'=>array('index','view','helpDesk'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles'=>array('user'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('saveMessage'),
				'roles'=>array('saveMessage'=>array('mod'=>$mod=Tasks::model()->findByPk($id))),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('saveStatus'),
				'roles'=>array('saveStatus'=>array('mod'=>$mod=Tasks::model()->findByPk($id))),
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

	public function actionSaveMessage($id){
		if(Yii::app()->request->isAjaxRequest){
			$model=new TasksActions;	
			echo $_POST['mess'];
			
			$model->ttext=$_POST['mess'];
			$model->type=1;
			$model->id_task=$id;

			$model->save();
		}
	}	

	public function actionSaveStatus($id){
		if(Yii::app()->request->isAjaxRequest){


			$model=Tasks::model()->findByPk($id);
			$model_act=new TasksActions;	
			echo $_POST['stat'];
			$model->status=$_POST['stat'];

			if($_POST['stat']==1 or $_POST['stat']==2){
				$model->timestamp_end=date('d.m.Y H:i:s');
			}

			$model->save();
			$model_act->ttext=$_POST['stat'];
			$model_act->type=0;
			$model_act->id_task=$id;
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

	public function actionHelpDesk($id_department,$type=3,$group=NULL){
		$this->layout='//layouts/column2';
		$this->id_department=$id_department;
		$this->group=$group;

		//$fu=new TasksActions;

		if(!Yii::app()->user->isGuest){
			$condition="id_department=".$id_department;
			if(!empty($this->group))
				$condition.=" and '".$this->group."'=ANY(\"group\")";
			$order="timestamp desc LIMIT 10";
			$model=Tasks::model()->findAll(array('condition'=>$condition,'order'=>$order));

			if(in_array($this->id_department,Yii::app()->user->id_departments)){
				if(Yii::app()->user->last_task!=$model[0]->id){
					if(!empty(Yii::app()->user->last_task))
						$this->isHorn=true;
					Yii::app()->user->last_task=$model[0]->id;
				}
			}
		}


		switch ($type) {
			//все, кроме помеченных как просмотренные
			case '0':
				$condition="id_department=".$id_department." and status not in (4)";
				$order="status asc,timestamp desc";
				break;
			//текущие
			case '1':
				$condition="id_department=".$id_department." and status in (0,1,5) ";
				$order="status asc,timestamp desc";
				break;
			
			//все
			case '2':
				$condition="id_department=".$id_department." ";
				$order="status asc,timestamp desc";
				break;

			//за день
			case '3':
				$condition="id_department=".$id_department." and ((timestamp>'".date('d.m.Y')." 00:00:00' or timestamp_end>'".date('d.m.Y')." 00:00:00') or status in (0,1,5))";
				$order="status asc,timestamp desc";
				break;
			default:
				
			break;
		}

		if(!empty($this->group))
			$condition.=" and '".$this->group."'=ANY(\"group\")";

		$model=Tasks::model()->findAll(array('condition'=>$condition,'order'=>$order));

		
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
