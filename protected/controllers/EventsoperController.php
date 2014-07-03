<?php

class EventsoperController extends Controller
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
				'actions'=>array('index','view','monupdate','agree','suggest'),
				'roles'=>array('user'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles'=>array('userOperationSV'),
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

public function actionSuggest(){
		if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])) {
  		$models = ListOperations::model()->suggestTag($_GET['term']);
  		$result = array();
  		foreach ($models as $m)
   		$result[] = array(
     		'label' => $m->name,
     		'value' => $m->name,
     		'id' => $m->id,
   		);
  		echo CJSON::encode($result);
 	}
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
		$model=new Eventsoper;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Eventsoper']))
		{
			$model->attributes=$_POST['Eventsoper'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
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

		if(isset($_POST['Eventsoper']))
		{
			$model->attributes=$_POST['Eventsoper'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionAgree($id){
		$model=$this->loadModel($id);
		$model->status=1;
		if($model->save())

				$this->redirect(array('/rooms/show'));
	}

		public function actionMonUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Eventsoper']))
		{
			if(!($model_new=Eventsoper::model()->find(array('condition'=>'t.id_eventsoper='.$id)))){
				$model_new=new Eventsoper;
			}
			$model_new->attributes=$_POST['Eventsoper'];
			unset($_POST['Eventsoper']);
			$model_new->id_eventsoper=$id;
			$model_new->status=3;
			//print_r($_POST);
			if($model_new->save()){
				$model->status=2;

				//print_r($model_new->attributes);
				//print_r($model->attributes);
				$model->save();
				$this->redirect(array('/rooms/show'));
			}
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
		$dataProvider=new CActiveDataProvider('Eventsoper');
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'modelLabelP'=>Eventsoper::$modelLabelP,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Eventsoper('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Eventsoper']))
			$model->attributes=$_GET['Eventsoper'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Eventsoper the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Eventsoper::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Eventsoper $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='eventsoper-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
