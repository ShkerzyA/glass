<?php

class EquipmentLogController extends Controller
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
				'actions'=>array('index','view','exportCart','showLog','printersLog'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','crefill'),
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

	public function access(){
		if(!(Yii::app()->user->checkAccess('inGroup',array('group'=>array('it')))))
            throw new CHttpException(403, 'У вас недостаточно прав');
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.


	 */
	public function actionPrintersLog(){
		$models=Equipment::printersWithLog();
		$this->render('printersLog',array(
			'model'=>$models,
		));
	}

	public function actionShowLog()
	{
		if(!empty($_POST['id']))
			$id=$_POST['id'];
		$eq=Equipment::model()->findByPk($id);
		echo $eq->full_name().'<br>';
		$logs=EquipmentLog::model()->findAll(array('condition'=>'t.object='.$id.' or (type=1 and \''.$id.'\'=details[2]) or (type in (3,4) and \''.$eq->inv.'\'=ANY("details"))','order'=>'t.timestamp DESC, t.type ASC'));
		echo '<table class=bordertable><tr><th>Дата/Время</th><th>Тип действия</th><th>Субьект</th><th>Объект</th><th>Детали</th></tr>';
		foreach ($logs as $v) {
			echo '<tr><td>'.$v->timestamp.'</td><td>'.$v->getType()['name'].'</td><td>'.$v->subject0->fio().'</td><td>'.($ob_name=($v->objectEq)?$v->objectEq->full_name():'').'</td><td>'.$v->details_full().'</td></tr>';
		}
		echo '</table>';
	}


	public function actionCreate()
	{
		$model=new EquipmentLog;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EquipmentLog']))
		{
			$model->attributes=$_POST['EquipmentLog'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

		public function actionCrefill($type='')
	{

		$model=new EquipmentLog;
		switch ($type) {
			case 'outgo':
				$model->type=3;
				break;
			case 'ingo':
				$model->type=4;
				break;
			default:
				$this->redirect(array('/admin/index'));
				break;
		}


		if(isset($_POST['EquipmentLog']))
		{
			$model->attributes=$_POST['EquipmentLog'];

			$errors=Equipment::cartMassMovie($model->type,$model->details);
			if(!empty($errors)){
				foreach ($errors as $v) {
					$model->addError('details',$v);
				}
			}else{
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('_formCRefill',array(
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

		if(isset($_POST['EquipmentLog']))
		{
			$model->attributes=$_POST['EquipmentLog'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

		public function actionExportCart()
	{
		$this->access();
		$this->layout='//layouts/leaf';
		$model=new EquipmentLog;
		$Xls=new Xls;
		$data=$model->search_for_export_cart();
		/*
		echo'<pre>';
		print_r($data);
		echo '</pre>';*/ 
		$Xls->exportLogCart($data);
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
		$dataProvider=new CActiveDataProvider('EquipmentLog');
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'modelLabelP'=>EquipmentLog::$modelLabelP,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new EquipmentLog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EquipmentLog']))
			$model->attributes=$_GET['EquipmentLog'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EquipmentLog the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=EquipmentLog::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EquipmentLog $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='equipment-log-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
