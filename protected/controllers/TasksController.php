<?php

class TasksController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $id_department;
	public $group;
	public $horn;
	public $isHorn;
	public $target_date;

	public $tasks_menu=array(
		array('name'=>'IT crowd','id_department'=>'1011','group'=>''),
		array('name'=>'Плотники','id_department'=>'1074','group'=>'carpenters'),
		array('name'=>'Сантехники','id_department'=>'1074','group'=>'plumbers'),
		array('name'=>'Электрики','id_department'=>'1074','group'=>'electricians'),
		array('name'=>'Вентиляция','id_department'=>'1074','group'=>'ventilation'),
		);
	public $rightWidget;

	public function init(){
		$this->formHorn();
	}
	/**
	 * @return array action filters
	 */

	private function formHorn(){
		$dir=scandir(Yii::getPathOfAlias('webroot').'/media/horn/');
		unset($dir[0]);
		unset($dir[1]);
		$horn=array_rand($dir);
		$this->horn=Yii::app()->request->baseUrl.'/media/horn/'.$dir[$horn];
		$this->isHorn=false;
	}

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
				'actions'=>array('index','view','create','helpDesk','report', 'reportOtd'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */

	public function actionReport($date='current_date'){

		$model=TasksActions::UserReportToday($date);

		$dt=($date=='current_date')?date('d.m.Y'):$date;

		
		$filename ='report.odt';
		$odf = new myOdt(Yii::getPathOfAlias('webroot').'/media/'.$filename);
		$user=Yii::app()->user;

		$odf->setVars('fio', $user->surname.' '.mb_substr($user->name,0,1,'UTF-8').'. '.mb_substr($user->patr,0,1,'UTF-8').'.', true, 'utf-8');
		$odf->setVars('date', $dt);

		$article = $odf->setSegment('articles');
		$i=1;
		foreach ($model as $v){
			$rep=explode('\/', $v->ttext);
 			$article->setVars('n',$i, true, 'utf-8');
 			$article->setVars('task',$rep[0], true, 'utf-8');
 			$article->setVars('description',$rep[1], true, 'utf-8');
 			$article->setVars('status',$rep[2], true, 'utf-8');
 			$article->setVars('note',$rep[3], true, 'utf-8');
		 	$article->merge();
		 	$i++;
		}
		$odf->mergeSegment($article);

		$odf->setVars('post', $user->postname,true, 'utf-8');
		$odf->exportAsAttachedFile(); 
		
	}	

	public function actionReportOtd($personInfo=false,$date='current_date'){
		$model=TasksActions::OtdelReportToday($date);

		
		$filename ='reportOtd.odt';

		$odf = new myOdt(Yii::getPathOfAlias('webroot').'/media/'.$filename);
		$user=Yii::app()->user;

		$dt=($date=='current_date')?date('d.m.Y'):$date;

		$odf->setVars('fio', $user->surname.' '.mb_substr($user->name,0,1,'UTF-8').'. '.mb_substr($user->patr,0,1,'UTF-8').'.', true, 'utf-8');
		$odf->setVars('date', $dt);
		$article = $odf->setSegment('articles');

		$i=1;
		foreach ($model as $pers){
			if(empty($pers->actions))
				continue;
			if($personInfo){
				$i=1;
				$article->setVars('n','', true, 'utf-8');
 				$article->setVars('task','', true, 'utf-8');
 				$article->setVars('description','', true, 'utf-8');
 				$article->setVars('status','', true, 'utf-8');
 				$article->setVars('note','', true, 'utf-8');
 				$article->setVars('sname',$pers->surname, true, 'utf-8');
 				$article->setVars('name',$pers->name, true, 'utf-8');
 				$article->setVars('patr',$pers->patr, true, 'utf-8');
 				$article->setVars('note','', true, 'utf-8');
				$article->merge();	
			}

		 	$article->setVars('sname','', true, 'utf-8');
 			$article->setVars('name','', true, 'utf-8');
 			$article->setVars('patr','', true, 'utf-8');
			foreach ($pers->actions as $v) {
				$rep=explode('\/', $v->ttext);
 				$article->setVars('n',$i, true, 'utf-8');
 				$article->setVars('task',$rep[0], true, 'utf-8');
 				$article->setVars('description',$rep[1], true, 'utf-8');
 				$article->setVars('status',$rep[2], true, 'utf-8');
 				$article->setVars('note',$rep[3], true, 'utf-8');
		 		$article->merge();
		 		$i++;
		 	}
		}
		$odf->mergeSegment($article);


		$odf->setVars('post', $user->postname,true, 'utf-8');
		$odf->exportAsAttachedFile(); 
		
	}	

	public function actionCreate()
	{
		$model=new Tasks;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tasks']))
		{
			$model->attributes=$_POST['Tasks'];

			if(!empty($_POST['fio']) and (!empty($_POST['phone']))){
				$model->ttext=$_POST['fio']." тел. ".$_POST['phone']."\n \n".$model->ttext;
			}


			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

		public function actionCreateActions()
	{
		$model=new TasksActions;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TasksActions']))
		{
			$model->attributes=$_POST['TasksActions'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('createactions',array(
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

		if(isset($_POST['Tasks']))
		{
			$model->attributes=$_POST['Tasks'];
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
			$this->redirect(Yii::app()->getUrlManager()->createUrl('tasks/helpDesk?id_department=1011'));
	}

	public function actionHelpDesk($id_department,$type=3,$group=NULL){
		$this->layout='//layouts/column2';

		
		$this->rightWidget=array(
			'df'=>$this->renderPartial('_date_filter',array('model'=>$model),true)
		);
		$this->target_date=(!empty($_GET['date']))?"'".$_GET['date']."'":"'".date('d.m.Y')."'";
		
		$this->id_department=$id_department;
		$this->group=$group;

		if(!Yii::app()->user->isGuest){
			$this->isHorn=Tasks::isHorn($id_department,$group);
		}
		$model=Tasks::tasksForOtdAndGroup($id_department,$type,$group,$this->target_date);
		$this->render('helpdesk',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Tasks');
		$this->render('index',array(
			'dataProvider'=>$dataProvider, 'modelLabelP'=>Tasks::$modelLabelP,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tasks('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tasks']))
			$model->attributes=$_GET['Tasks'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tasks the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tasks::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tasks $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tasks-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
