<?php

class CallLogController extends Controller
{
	public function actionIndex()
	{
		$model=new CallLog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CallLog'])){
			$model->attributes=$_GET['CallLog'];
		}
		$this->render('index',array('model'=>$model));
	}

	public function actionImport()
	{
		$file=array();
		if(isset($_FILES["f"])){
			$file=file($_FILES["f"]["tmp_name"]);
			foreach ($file as &$v) {
				$v=iconv('cp1251','UTF8',$v);
			}
			$file=CallLog::parseCallLog($file);

		}
		$this->render('import',array('file'=>$file));
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