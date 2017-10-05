<?php

class ActOfTransferController extends Controller
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
				'actions'=>array('index','view','actsForEq'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','export'),
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

	public function actionExport($id){
		$model=ActOfTransfer::model()->with('equipments')->findByPk($id);
		$dt=date('d.m.Y');
		$filename ='actOfTransfer.odt';
		$config=array('PATH_TO_TMP'=>Yii::getPathOfAlias('webroot'));
		$odf = new myOdt(Yii::getPathOfAlias('webroot').'/tpl/'.$filename,$config);

		$odf->setVars('id', $model->id, true, 'utf-8');
		$odf->setVars('date', $dt);

		$article = $odf->setSegment('articles');
		$i=1;
		foreach ($model->equipments as $eq){
 			$article->setVars('n',$i, true, 'utf-8');
 			$article->setVars('mark',$eq->type0->name.'/ '.$eq->getProducer().'/ '.$eq->mark, true, 'utf-8');
 			$article->setVars('serial',$eq->serial, true, 'utf-8');
 			$article->setVars('inv',$eq->inv, true, 'utf-8');
 			$article->setVars('note','', true, 'utf-8');
		 	$article->merge();
		 	$i++;
		}
		$odf->mergeSegment($article);
		$odf->setVars('transf', $model->getTransferring(), true, 'utf-8');
		$odf->setVars('recev', $model->getReceiving(), true, 'utf-8');

		$odf->exportAsAttachedFile(); 
		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ActOfTransfer;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ActOfTransfer']))
		{
			$model->attributes=$_POST['ActOfTransfer'];
			if($model->saveWithRelated('equipments'))
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
		if(!Yii::app()->user->checkAccess('updateAct',array('mod'=>$model)))
			throw new CHttpException(403, 'У вас недостаточно прав');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ActOfTransfer']))
		{
			$model->attributes=$_POST['ActOfTransfer'];
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
		$dataProvider=new CActiveDataProvider('ActOfTransfer');
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'modelLabelP'=>ActOfTransfer::$modelLabelP,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionActsForEq($id){
		$model=ActOfTransfer::model()->with('equipments')->findAll(array('condition'=>'equipments.id='.(int)$id.'','order'=>'t.timestamp DESC'));
		$this->renderPartial('indextable',array(
			'models'=>$model,
		),false,false);
	}

	public function actionAdmin()
	{
		$model=new ActOfTransfer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ActOfTransfer']))
			$model->attributes=$_GET['ActOfTransfer'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ActOfTransfer the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ActOfTransfer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ActOfTransfer $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='act-of-transfer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
