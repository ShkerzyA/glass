<?php

class ApiController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('saveMon'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionMessChat(){
	}

	public function actionSaveMon(){
		print_r($_REQUEST);
		$model=MonitoringEnvironment::model()->findByPk(1);
		if(!empty($_POST)){
			$model->attributes=$_POST;
			$model->save();
			Yii::app()->Tornado->updateMon();
		}
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}