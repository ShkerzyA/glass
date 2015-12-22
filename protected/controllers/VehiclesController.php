<?php

class VehiclesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $rightWidget;

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
				'actions'=>array('index','view','markSearch','searchNumber','checkVehiclesAccess','setAction'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('accounting'),
				'roles'=>array('user'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'expression'=>'Yii::app()->user->checkAccess("inGroup",array("group"=>array("security_admin")))',
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionMarkSearch(){
		if(!Yii::app()->request->isAjaxRequest){
			exit();
		}
			if(!empty($_POST['val'])){
				$val=mb_strtolower($_POST['val'],'UTF-8');
			}else{
				exit();
			}

			$criteria = new CDbCriteria;
			$criteria->with = array('producer0');
			


            $criteria->addCondition(array('condition'=>'lower(producer0.name) like \'%'.$val.'%\' or lower(t.name) like \'%'.$val.'%\''));
     		$criteria->distinct=True;

			//$criteria->condition = "type=:type and producer=:producer";
			//$criteria->params = array(':type'=>$_POST['type'],':producer'=>$_POST['producer']);
			//$criteria->distinct = True;
			//$criteria->group="mark";
			$criteria->order="producer0.name ASC, t.name ASC";

			$model=CarsMark::model()->findall($criteria);
			$this->renderPartial('/vehicles/markSearch', array('model'=>$model), false, false);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Vehicles;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Vehicles']))
		{
			$model->attributes=$_POST['Vehicles'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionAccounting(){
		$this->layout='//layouts/column1';
		$log=new Log;
		$model=new Vehicles;
		$finded_model=NULL;
		if(!empty($_POST['Vehicles'])){
			$model->attributes=$_POST['Vehicles'];
			$finded_model=Vehicles::model()->find(array('condition'=>"t.number='".$model->number."'"));
			if(empty($finded_model)){
					$finded_model=$model;
					//$log=new Log;
					//$log->saveLog('unknowCar',array('details'=>array(Vehicles::Ru2Lat($model->number)),'object_model'=>'Vehicles','object_id'=>NULL));
					//$this->redirect(array('accounting')); 
			}
			
		}


		$this->render('accounting',array(
			'model'=>$model,'finded_model'=>$finded_model
		));
	}

	public function actionSetAction()
	{


		$id =(!empty($_POST['Vehicles']['id']))?$_POST['Vehicles']['id']:NULL;
		if(!empty($id)){
			$model=$this->loadModel($id);
			$model->scenario='accountingCar';
		}else{
			$model=new Vehicles;
			$model->attributes=$_POST['Vehicles'];
		}
		
		if(isset($_POST['in']))
		{
			$model->status=2;
		}else if(isset($_POST['out'])){
			$model->status=1;
		}else if(isset($_POST['deny'])){
			$model->status=3;
		}

		if(!empty($model->id)){
			$model->save();
		}else{
			$log=new Log;
			$log->saveLog('unknowCar',array('details'=>array($model->status,Vehicles::Ru2Lat($model->number)),'object_model'=>'Vehicles','object_id'=>NULL));
		}

		$this->redirect(array('accounting')); 

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

		if(isset($_POST['Vehicles']))
		{
			$model->attributes=$_POST['Vehicles'];
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
		$dataProvider=new CActiveDataProvider('Vehicles');
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'modelLabelP'=>Vehicles::$modelLabelP,
		));
	}

	public function actionSearchNumber(){
		if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])) {
			$model=new Vehicles;
			$model->number=Vehicles::Ru2Lat($_GET['term']);
  			$models = Vehicles::model()->suggestNumbers(Vehicles::Ru2Lat($_GET['term']));
  			$result = array();
  			if(!empty($models)){
  				foreach ($models as $m)
   					$result[] = array(
     				'label' => $m->number,
     				'value' => $m->number,
     				'id' => $m->id,
   				);	
  			}else{
  				if($model->avtoNumber())
  				$result[] = array(
     				'label' => $model->number,
     				'value' => $model->number,
     				'id' => NULL,
   				);	
  			}
  			
  			echo CJSON::encode($result);
 		}
	}

	public function actionCheckVehiclesAccess($id){
		if (!Yii::app()->request->isAjaxRequest)
			return false;
		$model=$this->loadModel($id);
		$this->renderPartial('_carAccess',array('model'=>$model),false,false);
		$this->renderPartial('view',array('model'=>$model),false,false);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Vehicles('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Vehicles']))
			$model->attributes=$_GET['Vehicles'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Vehicles the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Vehicles::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Vehicles $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vehicles-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
