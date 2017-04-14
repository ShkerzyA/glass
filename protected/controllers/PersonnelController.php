<?php
//Yii::import('application.vendors.*');
//require_once('phpExcelReader/reader.php');

class PersonnelController extends Controller
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
				'actions'=>array('index','tiles','view','rootFillTree','AjaxFillTree','depposts','surnameSearch','birthdays','vacations','phones','suggest'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','tiles','view'),
				'expression'=>'Yii::app()->user->checkAccess("inGroup",array("group"=>array("it")))',
				'roles'=>array('user'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','inOpenFire','allInOpenFire'),
				'roles'=>array('moderator'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','import','firedButInWp','policInQuickq','inQQ'),
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
	public function actionajaxPost(){
		$id = Yii::app()->request->getPost('id');
       	$model=new PersonnelPostsHistory;
        $this->renderPartial('_form_post_hist', array('model'=>$model,'id'=>$id), false, true);
	}

	public function actionBirthdays(){
		$models=Personnel::model()->with('personnelPostsHistories:working')->working()->findAll(array('select'=>'t.surname, t.name, t.patr, t.birthday','condition'=>"(DATE_PART('doy',birthday::date)-DATE_PART('doy',current_date))<7 and (DATE_PART('doy',birthday::date)-DATE_PART('doy',current_date))>=0 and \"personnelPostsHistories\".id is not null",'order'=>"(DATE_PART('month',birthday::date)::char||DATE_PART('day',birthday::date))::int ASC"));
		$this->render('birthdays', array('models'=>$models));
	}

	public function actionVacations(){
		#$this->layout='//layouts/leaf';
		$models=Personnel::model()->with('zempleavs:near')->working()->findAll(array('condition'=>"zempleavs.empleav_rn is not null",'order'=>"zempleavs.startdate"));
		$this->render('vacations', array('models'=>$models));
	}

	public function actionajaxPostAdm(){
		$id = Yii::app()->request->getPost('id');
		$dataprov=new CActiveDataProvider('PersonnelPostsHistory', array(
    'criteria'=>array(
        'condition'=>'id_personnel='.$id,
    ),));

        $this->renderPartial('admin_post_hist', array('models'=>$dataprov,'id'=>$id), false, true);
	}

	
	public function actionSuggest(){
		if (Yii::app()->request->isAjaxRequest && isset($_GET['term'])) {
  			$models = Personnel::model()->suggestTag($_GET['term']);
  			$result = array();
  			foreach ($models as $m)
   			$result[] = array(
     			'label' => $m->surname.' '.$m->name.' '.$m->patr,
     			'value' => $m->surname.' '.$m->name.' '.$m->patr,
     			'id' => $m->id,
   			);
  			echo CJSON::encode($result);
 		}
	}
	

	public function actionInOpenFire($id,$inpolic=true){
		$model=$this->loadModel($id);		
		echo $model->inOpenFire($inpolic=true);

	}

	public function actionInQQ($id){
		$model=$this->loadModel($id);		
		if(empty($model->usersQqs)){
			$userQQ=new UsersQq;
			$userQQ->id_personnel=$model->id;
			$userQQ->save();	
			echo 'add';
		}
		echo 'ok';
		

	}


	public function actionPolicInQuickq(){
		$keys=array_keys(UsersQq::$postprefix);
		$keys="'".(implode("','",$keys))."'";
		$models=Personnel::model()->with('personnelPostsHistories.idPost','usersQqs')->findall(array('condition'=>"\"idPost\".post_rn in($keys)"));
		echo '<table>';
		echo '<tr><th>ФИО</th><th>Логин</th><th>Пароль</th></tr>';
		foreach($models as $v){
			if(!empty($v->usersQqs)){
				echo '<tr><td>'.$v->fio_full().'</td><td>'. $v->usersQqs->getLogin().'</td><td>'.$v->usersQqs->getPassword().'</td></tr>';
			}else{
				$userQQ=new UsersQq;
				$userQQ->id_personnel=$v->id;
				$userQQ->save();	
			}
			
			
		}
		echo'</table>';

	}

		public function actionAllInOpenFire(){
		$models=Personnel::model()->findall();
		foreach($models as $v){
			echo $v->inOpenFire($inpolic=false).'</br>';
		}

	}

	public function actionFiredButInWp(){
		$models=Personnel::model()->with('workplaces')->fired()->findAll(array('condition'=>'workplaces.id is not null'));
		$this->render('firedButInWp',array(
			'models'=>$models,
		));
	}


	public function actionSurnameSearch(){
		if(Yii::app()->request->isAjaxRequest){
			if(!empty($_POST['search'])){
				$surname=$_POST['search'];
			}else{
				$surname='';
			}

			if(!empty($surname)){
				$model=Personnel::model()->working()->with(
					array('personnelPostsHistories'=>array('alias'=>'personnelPostsHistories','scopes'=>array('working'),'joinType'=>'RIGHT JOIN')
						,'personnelPostsHistories.idPost'
						,"personnelPostsHistories.idPost.postSubdivRn"
						))->findall(array('condition'=>'LOWER("t".surname) LIKE (\'%'.mb_strtolower($surname,'UTF-8').'%\')'));				
			}else{
				$model=NULL;
			}

			$modelN=(!empty($_POST['modelN']))?$_POST['modelN']:'';
			$action=(!empty($_POST['action']))?$_POST['action']:'';
			
			$this->renderPartial('surnameSearch', array('surname'=>$surname,'model'=>$model,'action'=>$action, 'field'=>$_POST['field'], 'modelN'=>$modelN), false, true);
		}else{
			exit();
		}
	}
	

	public function actionDepposts(){
		if(Yii::app()->request->isAjaxRequest){
			$model=Personnel::model()->working()->with('personnelPostsHistories')->with('personnelPostsHistories.idPost')->with("personnelPostsHistories.idPost.postSubdivRn")->findall(array('condition'=>'"postSubdivRn".id='.$_POST['id_department']));
			$this->renderPartial('choise_posts', array('model'=>$model), false, true);
		}else{
			exit();
		}
	}

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>Personnel::model()->with(array('workplaces','personnelPostsHistories','usersQqs','zempleavs'))->findByPk($id),
		));
	}



	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Personnel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Personnel']))
		{
			$model->attributes=$_POST['Personnel'];
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

		if(isset($_POST['Personnel']))
		{
			$model->attributes=$_POST['Personnel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionImport()
	{
	
		$xls=new Xls();
		$bgf=$xls->import_Personnel();
		$this->render('import',array('bfg'=>$bfg));

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

		//$this->layout='//layouts/column1';
		$model=new Personnel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Personnel']))
		$model->attributes=$_GET['Personnel'];
		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionTiles()
	{

		$this->layout='//layouts/column1';
		$model=new Personnel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Personnel']))
		$model->attributes=$_GET['Personnel'];
		$this->render('tiles',array(
			'model'=>$model,
		));
	}

	public function actionPhones()
	{

		$this->layout='//layouts/column1';
		$model=new Personnel('search_pers_phones');
		//$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Personnel'])){
			$model->attributes=$_GET['Personnel'];
		}

		$this->render('phones',array(
			'model'=>$model,
		));


	}

	

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Personnel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Personnel']))
			$model->attributes=$_GET['Personnel'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Personnel the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Personnel::model()->with(array('personnelPostsHistories'=>array('alias'=>'personnelPostsHistories')))->find(array('condition'=>'t.id='.$id,'order'=>'"personnelPostsHistories".date_end DESC'));
		//$model=Personnel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Personnel $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='personnel-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
