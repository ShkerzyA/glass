<?php

class EquipmentController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	private $preset=array(
		'default'=>array(
			array('type'=>'0'),
			array('type'=>'1'),
			array('type'=>'6'),
			array('type'=>'7'),
			),
		'HP'=>array(
			array('type'=>'0','producer'=>0,'mark'=>'HP PRO 3500 SERIES MT'),
			array('type'=>'1','producer'=>0,'mark'=>'PAVILION 23 XI'),
			array('type'=>'6','producer'=>10),
			array('type'=>'7'),
			),
		);

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','createPack','update','markSearch','delete'),
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
		$model=new Equipment;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Equipment']))
		{
			$model->attributes=$_POST['Equipment'];
			if($model->save())
				$this->redirect(array('/Workplace/view','id'=>$model->id_workplace));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	public function actionCreatePack($preset='default')
	{
		$this->layout='//layouts/column1';
		$items[]=new Equipment;
		$items[]=new Equipment;
		$items[]=new Equipment;
		$items[]=new Equipment;

		$attr=$this->preset[$preset];

		$items[0]->attributes=$attr[0];
		$items[1]->attributes=$attr[1];
		$items[2]->attributes=$attr[2];
		$items[3]->attributes=$attr[3];

		//$items[4]->type=3;

		foreach ($items as &$it) {
			$it->id_workplace=$_GET['Equipment']['id_workplace'];
			//$it->id_workplace=23;
		}

    	if(isset($_POST['Equipment']))
    	{
       		$valid=true;
        	foreach($items as $i=>&$item)
        	{
        		echo $i;
            	if(isset($_POST['Equipment'][$i]))
                	$item->attributes=$_POST['Equipment'][$i];
            	$valid=$item->validate() && $valid;
        	}
        	$items=array_reverse($items);
        	if($valid){
        		foreach ($items as $item) {
        			if(!empty($item->mark))
        				$item->save();
        		}
        		$this->redirect(array('/Workplace/view','id'=>$items[0]->id_workplace));
        	}
    	}
    	// отображаем представление с формой для ввода табличных данных
    	$this->render('createPack',array('items'=>$items));
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

		if(isset($_POST['Equipment']))
		{
			$model->attributes=$_POST['Equipment'];
			if($model->save())
				$this->redirect(array('/Workplace/view','id'=>$model->id_workplace));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionMarkSearch(){
		if(!Yii::app()->request->isAjaxRequest){
			exit();
		}
			if(!empty($_POST['search'])){
				$surname=$_POST['search'];
			}else{
				$surname='no';
			}

			$criteria = new CDbCriteria;
			$criteria->select = "mark";
			$criteria->condition = "type=:type and producer=:producer";
			$criteria->params = array(':type'=>$_POST['type'],':producer'=>$_POST['producer']);
			$criteria->distinct = True;

			$model=Equipment::model()->findall($criteria);
			$this->renderPartial('markSearch', array('model'=>$model), false, false);
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{

		$model=$this->loadModel($id);
		$id_wp=$model->id_workplace;
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(array('/Workplace/view','id'=>$id_wp));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Equipment');
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'modelLabelP'=>Equipment::$modelLabelP,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Equipment('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Equipment']))
			$model->attributes=$_GET['Equipment'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Equipment the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Equipment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Equipment $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='equipment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
