<?php

class CallLogController extends Controller
{
	public $layout='/layouts/column2';
	public function actionIndex()
	{

		$model=new CallLogAuto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CallLogAuto'])){
			$model->attributes=$_GET['CallLogAuto'];
		}
		$this->render('index',array('model'=>$model));
	}

	public function actionIndexApus()
	{
		$model=new CallLogApus('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CallLogApus'])){
			$model->attributes=$_GET['CallLogApus'];
		}
		$this->render('index',array('model'=>$model));
	}

	public function actionImport()
	{
		$file=array();
		$result='';
		if(isset($_FILES["f"])){
			$file=file($_FILES["f"]["tmp_name"]);
			foreach ($file as &$v) {
				$v=iconv('cp1251','UTF8',$v);
			}
			$file=CallLog::parseCallLog($file);
			$result='Данные импортированы';

		}
		$this->render('import',array('result'=>$result));
	}

	public function actionExport()
	{
		$this->layout='//layouts/leaf';
		$model=new CallLogAuto('search');
		$model->unsetAttributes();
		if(isset($_GET['CallLogAuto'])){
			$model->attributes=$_GET['CallLogAuto'];
		}
		$Xls=new Xls;
		$data=$model->search(1);
		$Xls->exportLogCall($data,'auto');
	}

	public function actionExportApus()
	{
		$this->layout='//layouts/leaf';
		
		$model=new CallLogApus('search');
		$model->unsetAttributes();
		if(isset($_GET['CallLogApus'])){
			$model->attributes=$_GET['CallLogApus'];
		}
		$Xls=new Xls;
		$data=$model->search(1);
		$Xls->exportLogCall($data,'apus');
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
