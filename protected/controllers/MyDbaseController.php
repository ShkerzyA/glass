<?php

class MyDbaseController extends Controller
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('ReadPerson','ImportOtdel','ImportPersonnel','ImportOtdelPosts','ImportPersonnelPostsHistory','load_xls'),
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

	public function actionLoad_xls(){

		$xls=new Xls();
		$xls->load('ZFCAC.xls');

	}

	public function actionReadPerson()
	{
		$model=new MyDbase;
		
		$person=$model->read_table('person.dbf');

		$this->render('ReadPerson',array(
			'model'=>$model,
			'person'=>$person,
		));
	}

	public function actionImportOtdel()
	{
		$model=new MyDbase;
		
		$result=$model->otdelImport();

		$this->render('ShowMass',array(
			'model'=>$model,
			'result'=>$result,
		));
	}

	public function actionImportPersonnel()
	{
		$model=new MyDbase;
		
		$result=$model->personnelImport();

		$this->render('ShowMass',array(
			'model'=>$model,
			'result'=>$result,
		));
	}

	public function actionImportOtdelPosts()
	{
		$model=new MyDbase;
		
		$result=$model->otdelPostsImport();

		$this->render('ShowMass',array(
			'model'=>$model,
			'result'=>$result,
		));
	}

	public function actionImportPersonnelPostsHistory()
	{
		$model=new MyDbase;
		
		$result=$model->personnelPostsHistoryImport();

		$this->render('ShowMass',array(
			'model'=>$model,
			'result'=>$result,
		));
	}

}
