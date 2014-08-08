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
				'actions'=>array('index','view','phones','rootFillTree','AjaxFillTree','depposts','surnameSearch','suggest'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles'=>array('moderator'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','import'),
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
	

	public function actionSurnameSearch(){
		if(Yii::app()->request->isAjaxRequest){
			if(!empty($_POST['search'])){
				$surname=$_POST['search'];
			}else{
				$surname='';
			}

			if(!empty($surname)){
				$model=Personnel::model()->working()->with('personnelPostsHistories')->with('personnelPostsHistories.idPost')->with("personnelPostsHistories.idPost.postSubdivRn")->findall(array('condition'=>'LOWER("t".surname) LIKE (\''.mb_strtolower($surname,'UTF-8').'%\')'));				
			}else{
				$model=NULL;
			}
			
			$this->renderPartial('surnameSearch', array('surname'=>$surname,'model'=>$model, 'field'=>$_POST['field'], 'modelN'=>$_POST['modelN']), false, true);
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
			'model'=>$this->loadModel($id)->with('workplaces,PersonnelPostsHistory'),
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

		$this->layout='//layouts/column1';
		$model=new Personnel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Personnel']))
		$model->attributes=$_GET['Personnel'];


		$this->render('index',array(
			'model'=>$model,
		));


	}

		public function actionPhones()
	{

		$this->layout='//layouts/column1';
		$model=new Personnel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Personnel']))
			$model->attributes=$_GET['Personnel'];

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
