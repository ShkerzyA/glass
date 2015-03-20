<?php

class MedicalEquipmentController extends Controller
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

	public function access(){
		if(!(Yii::app()->user->checkAccess('inGroup',array('group'=>array('medequipment')))))
            throw new CHttpException(403, 'У вас недостаточно прав');
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
				'actions'=>array('index','view','plan','create','export'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'roles'=>array('moderator'),
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
		$this->access();
		$model=new MedicalEquipment;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MedicalEquipment']))
		{
			$model->attributes=$_POST['MedicalEquipment'];
			if($model->save())
				$this->redirect(array('plan'));
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
		$this->access();
		$model=$this->loadModel($id);
		if(isset($_POST['MedicalEquipment']))
		{
			$model->attributes=$_POST['MedicalEquipment'];
			if($model->save())
				$this->redirect(array('plan'));
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

	public function actionPlan()
	{
		$this->access();
		$this->layout='//layouts/leaf';
		$model=new MedicalEquipment('search');
		$model->unsetAttributes();
		$model->creator=Yii::app()->user->id_pers;  // clear any default values
		$model->date=date('d.m.Y');
		if(isset($_GET['MedicalEquipment']))
			$model->attributes=$_GET['MedicalEquipment'];




		$this->render('plan',array(
			'model'=>$model,
		));
	}


		public function actionExport()
	{
	
		$this->access();
		$this->layout='//layouts/leaf';
		$model=new MedicalEquipment('search');
		$model->unsetAttributes();
		$model->creator=Yii::app()->user->id_pers;  // clear any default values
		$model->date=date('d.m.Y');
		if(isset($_GET['MedicalEquipment']))
			$model->attributes=$_GET['MedicalEquipment'];

		$Xls=new Xls;
		$data=$model->search_for_export();
		$Xls->exportMedEq($data);
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->access();
		$dataProvider=new CActiveDataProvider('MedicalEquipment');
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'modelLabelP'=>MedicalEquipment::$modelLabelP,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MedicalEquipment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MedicalEquipment']))
			$model->attributes=$_GET['MedicalEquipment'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MedicalEquipment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MedicalEquipment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MedicalEquipment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='medical-equipment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
