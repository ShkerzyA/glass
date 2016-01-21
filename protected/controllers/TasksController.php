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
		array('name'=>'IT crowd','group'=>'it','rule'=>array('it')),
		array('name'=>'Плотники','group'=>'carpenters','rule'=>array()),
		array('name'=>'Сантехники','group'=>'plumbers','rule'=>array()),
		array('name'=>'Электрики','group'=>'electricians','rule'=>array()),
		array('name'=>'Вентиляция','group'=>'ventilation','rule'=>array()),
		);
	public $rightWidget;

	public function init(){
	}
	/**
	 * @return array action filters
	 */

	public function mayShow($rule=NULL){
		if(empty($rule)){
			return true;
		}else{
			if(Yii::app()->user->checkAccess('inGroup',array('group'=>$rule)))
				return true; 
		}
		return false;
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
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update','join','create','helpDesk','report', 'reportOtd','sameTasks','helpDeskProject'),
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
		$model=$this->loadModel($id);
		if(!Yii::app()->user->checkAccess('viewTs',array('mod'=>$model)))
			throw new CHttpException(403, 'У вас недостаточно прав');
		$this->rightWidget=array(
			'df'=>array($this->renderPartial('_subscribe_form',array('model'=>$model),true))
		);
		$this->render('view',array(
			'model'=>$model,
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
		$odf = new myOdt(Yii::getPathOfAlias('webroot').'/tpl/'.$filename);
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
		/*
		echo '<pre>';
		foreach ($model as $v) {
			print_r($v->attributes);
			foreach ($v->actions as $x) {
				print_r($x->attributes);
			};
		}
		echo '</pre>'; */
		//exit();
		
		$filename ='reportOtd.odt';

		$odf = new myOdt(Yii::getPathOfAlias('webroot').'/tpl/'.$filename);
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

			if($model->save()){
				Yii::app()->Tornado->updateTasks();
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		switch ($model->type) {
				case 1:
					$model->tname='Зам. карт.';
					break;
				
				default:
					break;
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

	public function actionJoin($id,$id_pers=NULL){
		$model=$this->loadModel($id);
		$id_pers=(!empty($id_pers))?$id_pers:Yii::app()->user->id_pers;
		$pers=Personnel::model()->findByPk($id_pers);
		$model->join($id_pers);

		if($model->save()){
			$mess=new TasksActions();
			$mess->type=1;
			$mess->ttext='Подписан: '.$pers->fio_full();
			$mess->id_task=$model->id;
			$mess->save();
			$this->redirect(array('view','id'=>$model->id));
		}

				
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(!Yii::app()->user->checkAccess('updateTs',array('mod'=>$model)))
			throw new CHttpException(403, 'У вас недостаточно прав');


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tasks']))
		{
			$model->attributes=$_POST['Tasks'];
			if($model->save()){
				Yii::app()->Tornado->updateTasks();
				$this->redirect(array('view','id'=>$model->id));
			}
				 
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
		Yii::app()->Tornado->updateTasks();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(Yii::app()->getUrlManager()->createUrl('tasks/helpDesk'));
	}

	public function actionHelpDeskProject(){
		$this->layout='//layouts/leaf2';
		$model=new Projects();
		$models=Projects::myExecProjects();
		$this->render('helpdeskproject',array(
				'model'=>$model,'models'=>$models));
	}
	


	public function actionHelpDesk($type=3,$group=NULL){
		$this->layout='//layouts/column2';

		
		$this->rightWidget=array(
			'df'=>array($this->renderPartial('_date_filter',array(),true)),
			'cc'=>array($this->renderPartial('/equipment/countCart',array('model'=>Equipment::countCart()),true,false),'it')
		);

		$this->target_date=(!empty($_GET['date']))?"'".$_GET['date']."'":"'".date('d.m.Y')."'";
		
		//$this->id_department=$id_department;

		$this->group=!empty($group)?$group:NULL;
		$group=!empty($group)?array($group):array();


		if(!Yii::app()->user->isGuest){
			$this->isHorn=Tasks::isHorn();
		}
		//$model=Tasks::tasksForOtdAndGroup($id_department,$type,$group,$this->target_date);
		$model=Tasks::GroupTasks($group,$type,$this->target_date);
		if(Yii::app()->request->isAjaxRequest){
			$this->renderPartial('_helpdesk',array(
				'model'=>$model,
			),false,false);
		}else{
			$this->render('helpdesk',array(
				'model'=>$model,
			));
		}
	}

	public function actionSameTasks($id,$type){
		if(Yii::app()->request->isAjaxRequest){
			switch ($type) {
				case 'cab':
					$cab=Cabinet::model()->findByPk($id);
					$condition=array();
					foreach ($cab->workplaces as $wp) {
						$con="(('".$wp->id."'"."=t.details[1] and t.type=0)";
						foreach ($wp->equipments as $equip){
							$con.=" OR ('".$equip->id."'"."=t.details[1] and t.type=1)";	
						}
						$con.=')';
						$condition[]=$con;	
					}
					$condition=implode(' OR ',$condition);
					break;
				case 'wp':
					$wp=Workplace::model()->findByPk($id);
					$condition="('".$id."'"."=t.details[1] and t.type=0)";
					foreach ($wp->equipments as $equip){
						$condition.=" OR ('".$equip->id."'"."=t.details[1] and t.type=1)";	
					}
					break;
				case 'eq':
					$eq=Equipment::model()->findByPk($id);
					$condition="('".$id."'"."=t.details[1] and t.type=1)";
					$condition.="OR ('".$eq->idWorkplace->id."'"."=t.details[1] and t.type=0)";
					break;
				default:
					return false;
					break;
			}
			$models=Tasks::model()->findAll(array('condition'=>$condition,'order'=>'t.timestamp DESC'));
			$this->renderPartial('_helpdesk',array(
				'model'=>$models,
			),false,false);
		}
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
