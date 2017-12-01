<?php

class ProjectsController extends Controller
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
				'actions'=>array('index','view','projectGroupMembers'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','altavista'),
				'roles'=>array('moderator'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','allStat','projectsExecutors'),
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
	public function actionProjectGroupMembers($id,$modelN)
	{
		$model=$this->loadModel($id);
		$res=Personnel::groupMembers($model->group);
		$this->renderPartial('choise_executors',array('model'=>$res,'mn'=>$modelN),false,false);
		
	}

	public function actionAltavista(){
		$this->layout='//layouts/leaf2';
		$pjArr=array();
		$psArr=array();
		$eArr=array();
		$personnel=Personnel::groupMembers(Yii::app()->user->groups);
		$projects=Projects::myGroupProjects();

		$i=3;
		foreach ($personnel as $p => $f) {
			$psArr[]="{id:'ps".$p."',label: '".$f."',x: 1,y: ".(($i)*2).", size: 1,color: '#00ff00'}";
			$i++;
		}
		
		$i=1;
		$j=1;
		foreach ($projects as $p) {
			$pi=$p->actualTaskCount();
			$size=(!empty($pi[0]['cou']))?$pi[0]['cou']:'1';
			$pjArr[]="{id:'pj".$p->id."',label: '".$p->name."',x: 40, y: ".($i).", size: ".pow($size,1/2).",color: '#ff0000'}";
			$i++;
			foreach ($p->executors as $e) {
				if(!empty($e) and !empty($personnel[$e])){
					$eArr[]="{id:'e".$j."',source: 'ps".$e."' ,target: 'pj".$p->id."',size: 5, color: '#ccc'}";
					$j++;
				}
			}
 		}
		$nodesPs="[".implode(',',$psArr)."]";
		$nodesPj="[".implode(',',$pjArr)."]";
		$edges="[".implode(',',$eArr)."]";

		//$edges="[{id:'e1',source: 'ps2' ,target: 'pj13',size: 1,color: '#ccc'}]";

		//echo $edges;
		//die();

		$this->renderPartial('altavista',array('nodesPj'=>$nodesPj,'nodesPs'=>$nodesPs,'edges'=>$edges),false,true);
	}



	public function actionAllStat(){
		$this->layout='//layouts/column1';
		$personnel=Personnel::groupMembers(Yii::app()->user->groups,True);
		$projects=Projects::myGroupProjects();
		$persStat=Projects::allProjectsPersStat();
		$commonStat=Projects::allProjectsStat();

		$this->render('allStat',array('personnel'=>$personnel,'projects'=>$projects,'persStat'=>$persStat,'commonStat'=>$commonStat));
	}

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
		$model=new Projects;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Projects']))
		{
			$model->attributes=$_POST['Projects'];
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

		if(isset($_POST['Projects']))
		{
			$model->attributes=$_POST['Projects'];
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
		$dataProvider=new CActiveDataProvider('Projects');
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'modelLabelP'=>Projects::$modelLabelP,
		));
	}

	public function actionProjectsExecutors(){
		$this->render('projectsExecutors',array(
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Projects('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Projects']))
			$model->attributes=$_GET['Projects'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Projects the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Projects::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Projects $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='projects-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
